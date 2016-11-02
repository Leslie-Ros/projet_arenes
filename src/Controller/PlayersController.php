<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Controller;
define('GOOGLE_OAUTH_CLIENT_ID', '829209634329-n85t946nfo3tdjoh7aasrkn90knodjvg.apps.googleusercontent.com');
define('GOOGLE_OAUTH_CLIENT_SECRET', 'WZ5byDnZBqeBMSxx4eZ1-Hf0');
define('GOOGLE_OAUTH_REDIRECT_URI', 'http://localhost/projet_arenes/Players/googlecallback');
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Error\Debugger;
use \Cake\Network\Exception;
use Cake\Utility\Text;
use Google_Client;
use Google_Service_Oauth2;
use Cake\Mailer\Email;


class PlayersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
//         $this->Auth->allow(['add', 'logout']);
        // Pages accessibles sans être connecté 
        $this->Auth->allow('login');
        $this->Auth->allow('forgetpassword');
        $this->Auth->allow('googlelogin');
        $this->Auth->allow('googlecallback');
        $this->Auth->allow('logout');
        $this->Auth->allow('add');
        $this->Auth->allow('index');
    }
//
//     public function index()
//     {
//        $this->set('players', $this->Players->find('all'));
//    }
//
//    public function view($id)
//    {
//        $players = $this->Players->get($id);
//        $this->set(compact('players'));
//    }
    public function add()
    {
        $player = $this->Players->newEntity();
        if ($this->request->is('post')) {
            $player = $this->Players->patchEntity($player, $this->request->data);
            if ($this->Players->save($player)) {
                $this->Flash->success(__("L'utilisateur a été sauvegardé."));
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__("Impossible d'ajouter l'utilisateur."));
        }
        $this->set('player', $player);
    }
    
     public function login()
    {
         $this->loadModel('Fighters');
         
         if ($this->request->is('post')) {
            debug($this->Auth->identify());
            $player = $this->Auth->identify();
            Debugger::dump($player);
            if ($player) {
                $session = $this->request->session();
                $session->write('User.player_id', $player['id']);
                $this->Auth->setUser($player);
                if ($this->Fighters->getDefaultFighterId($player['id'])!=null)
                   $this->request->session()->write('User.fighter_id', $this->Fighters->getDefaultFighterId($player['id'])); 
                
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }
    public function logout()
    {
        $this->request->session()->destroy('access_token');
        $this->Flash->success(__("Vous êtes maintenant déconnecté."));
        $this->request->session()->delete('User.player_id');
        if ($this->request->session()->check('User.fighter_id'))
        { $this->request->session()->delete('User.fighter_id');}
        return $this->redirect($this->Auth->logout());
    }
    
 public function forgetpassword() {
     $this->loadModel('Players');
     if ($this->request->is('post')) {
        $email=$this->request->data['email'];
        $player=$this->Players->findByEmail($email);
        $newpassword = $this->Players->chaine_aleatoire(5,'azertyuiopqsdfghjklmwxcvbn123456789');
        $player->password = $newpassword;
        if ($this->Players->save($player)) {
            $email = new Email('default');
            $email
                    ->to($player->email)
                    ->subject('Nouveau password webarena')
                    ->from(['webarenaprojet@gmail.com' => 'WebArena'])
                    ->send('Voici votre nouveau password: ' . $newpassword);
        } else {
            $this->Flash->error(__('Impossible de générer un nouveau password'));
        }
        return $this->redirect(['action' => 'login']);
     }
 }
    
 public function googlelogin()
    {
        $client = new Google_Client();
        $client->setClientId(GOOGLE_OAUTH_CLIENT_ID);
        $client->setClientSecret(GOOGLE_OAUTH_CLIENT_SECRET);
        $client->setRedirectUri(GOOGLE_OAUTH_REDIRECT_URI);
        $client->setScopes(array(
            "https://www.googleapis.com/auth/userinfo.profile",
            'https://www.googleapis.com/auth/userinfo.email'
        ));
        
        $url = $client->createAuthUrl();
        $this->redirect($url);
    }
    public function googlecallback()
    {     
        $this->loadModel('Players'); $this->loadModel('Fighters');
        $client = new Google_Client();
        /* Création de notre client Google */
        $client->setClientId(GOOGLE_OAUTH_CLIENT_ID);
        $client->setClientSecret(GOOGLE_OAUTH_CLIENT_SECRET);
        $client->setRedirectUri(GOOGLE_OAUTH_REDIRECT_URI);
        $client->setScopes(array(
            "https://www.googleapis.com/auth/userinfo.profile",
            'https://www.googleapis.com/auth/userinfo.email'
        ));
        $client->setApprovalPrompt('auto');
 
        /* si dans l'url le paramètre de retour Google contient 'code' */
        if (isset($this->request->query['code'])) {
            // Alors nous authentifions le client Google avec le code reçu
            $client->authenticate($this->request->query['code']);
            // et nous plaçons le jeton généré en session
            $this->request->Session()->write('access_token', $client->getAccessToken());
        }
     
        /* si un jeton est en session, alors nous le plaçons dans notre client Google */
        if ($this->request->Session()->check('access_token') && ($this->request->Session()->read('access_token'))) {
            $client->setAccessToken($this->request->Session()->read('access_token'));
        }
        
        /* Si le client Google a bien un jeton d'accès valide */
        if ($client->getAccessToken()) {
            // alors nous écrivons le jeton d'accès valide en session
            $this->request->Session()->write('access_token', $client->getAccessToken());
            // nous créons une requête OAuth2 avec le client Google paramétré
            $oauth2 = new Google_Service_Oauth2($client);
            // et nous récupérons les informations de l'utilisateur connecté
            $user = $oauth2->userinfo->get();
            try {
                if (!empty($user)) {
                    // si l'utilisateur est bien déclaré, nous vérifions si dans notre table Users il existe l'email de l'utilisateur déclaré ou pas
                    $result = $this->Players->find('all')
                                            ->where(['email' => $user['email']])
                                            ->first();
                    if ($result) {
                        // si l'email existe alors nous déclarons l'utilisateur comme authentifié sur CakePHP
                        $this->Auth->setUser($result->toArray());
                        //on initialise les mêmes variables de session que pour la connexion classique
                        /*pr($result);*/$this->request->session()->write('User.player_id', $result['id']);
                        if ($this->Fighters->getDefaultFighterId($result['id'])!=null)
                            $this->request->session()->write('User.fighter_id', $this->Fighters->getDefaultFighterId($result['id'])); 
           
                        // et nous redirigeons vers la page de succès de connexion
                        $this->redirect($this->Auth->redirectUrl());
                        $this->Flash->success(__("Vous êtes maintenant connecté."));
                    } else {
                        // si l'utilisateur n'est pas dans notre utilisateur, alors nous le créons avec les informations récupérées par Google+
                        $data = array();
                        $data['email'] = $user['email'];
                        $data['password'] = $user['id'];
                        $uid = Text::uuid();
                        $entity = $this->Players->newEntity($data);
                        $entity->id = $uid;
                        $entity->google_id = $user['id'];
                        if ($this->Players->save($entity)) {
                            // et ensuite nous déclarons l'utilisateur comme authentifié sur CakePHP
                            $data['id'] = $entity->id;
                            $this->Auth->setUser($data);
                            //on initialise les mêmes variables de session que pour la connexion classique
                            $this->request->session()->write('User.player_id', $data['id']);
                            if ($this->Fighters->getDefaultFighterId($data['id'])!=null)
                                   $this->request->session()->write('User.fighter_id', $this->Fighters->getDefaultFighterId($data['id'])); 
               
                            $this->redirect($this->Auth->redirectUrl());
                            $this->Flash->success(__("Vous êtes maintenant connecté."));
                        } else {
                            $this->Flash->set('Erreur de connection');
                            // et nous redirigeons vers la page de succès de connexion
                            $this->redirect(['action' => 'login']);
                        }
                    }
                } else {
                    // si l'utilisateur n'est pas valide alors nous affichons une erreur
                    $this->Flash->set('Erreur les informations Google n\'ont pas été trouvée');
                    $this->redirect(['action' => 'login']);
                }
            } catch (Exception $e) {
                $this->Flash->set('Grosse erreur Google, ca craint');
                return $this->redirect(['action' => 'login']);
            }
        }
    }

}
