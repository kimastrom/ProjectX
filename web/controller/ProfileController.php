<?php

require_once dirname(__FILE__) . '/../view/ProfileView.php';
require_once dirname(__FILE__) . '/../model/GravatarHandler.php';
require_once dirname(__FILE__) . '/../model/UserHandler.php';

class ProfileController
{

    private $_profileView;
    private $_userHandler;
    private $_gravatarHandler;
    private $_snippetHandler;
    private $_commentHandler;
    private $_data;

    public function __construct()
    {
        $this->_profileView = new ProfileView();
        $this->_userHandler = new UserHandler();
        $this->_gravatarHandler = new GravatarHandler();
        $this->_snippetHandler = new SnippetHandler();
        $this->_commentHandler = new CommentHandler();

    }

    public function doControll()
    {
        $html = '';
        if (AuthHandler::isLoggedIn()) {
            //Which profile is shown
            $user = $this->setProfileUser();
            
            //Get data from user 
            $email = $user->getEmail();
            $id = $user->getID();
            $this->_data['isAdmin'] = AuthHandler::isAdmin();
            $this->_data['isOwner'] = AuthHandler::isOwner($email);
            $this->_data['email'] = $email;

            //Submenu controll for profile pages
            if ($page = $this->_profileView->getPage()) {
                //Show created snippets by user
                if ($page == 'created') {
                    $this->showCreatedSnippets($id);
                } else if ($page == 'commented') {
                    $this->showCommentedSnippets($id);
                } else if ($page == 'liked') {
                    $this->showLikedSnippets($id);
                } else if ($page == 'disliked') {
                    $this->showDislikedSnippets($id);
                } else {
                    if($page == 'settings') {
                        if(AuthHandler::isOwner($email) || AuthHandler::getRole() == 2) {
                            //Generate new Api key
                            $this->generateApiKey($id, $email);
                            $this->showSettingsPage($id, $user->getApiKey(), $user);
                        } else {
                            $this->_data['content'] = 'You must be the owner of to do this.';
                        }
                    } else if($page == 'search') {
                        if($user->isAdmin()) {
                            $this->showUserSearch($id);
                        } else {
                            $this->_data['content'] = 'You must be an admin to do this.';
                        }
                    } else {
                        $this->_data['content'] = 'The page you are looking for does not exist.';
                    }

                }
            } else {
                $this->_data['content'] = '';
            }

            //set stats of userActivities
            $this->setStats($id);
            //Get avatar for user
            $avatar = $this->_gravatarHandler->getProfileGravatar($email);
            $name = $user->getName();
            $html .= $this->_profileView->profile($avatar, $name, $this->_data, $user);
        } else {
            header('location: /');
        }

        return $html;
    }

    /**
     * @param $id User id
     * @param $email User email
     */
    private function generateApiKey($id, $email) 
    {
        if (AuthHandler::isOwner($email) || AuthHandler::isAdmin()) {
            $this->_data['apiKey'] = AuthHandler::getUser()->getApiKey();

            if (!empty($_GET['api_key']) && $_GET['api_key'] == 'generate') {
                $newKey = $this->_userHandler->changeApiKey($id);
                if ($newKey != false) {
                    AuthHandler::getUser()->setApiKey($newKey);
                    $this->_data['apiKey'] = AuthHandler::getUser()->getApiKey();
                } else {
                    Log::userError('could not generate new api key', $email);
                    return false;
                }
            }
        }
    }

    /**
     * Get wich user to be shown
     */
    public function setProfileUser() 
    {
        $user = AuthHandler::getUser(); 
        //Se ifall efterfrågade användaren finns
        if($user->getRoleName() == 'admin' && isset($_GET['username'])){
            $user = $this->_userHandler->getUserByEmail($_GET['username']);
            
            //Om användaren inte existerar sätt den inloggade användaren
            if(!$user) {
               $user = AuthHandler::getUser();
            }
        }

        return $user;
    }

    /**
     * @param $id User id
     */
    private function setStats($id) 
    {
        $this->_data['snippets'] = $this->_snippetHandler->getSnippetsByUser($id);
        $this->_data['likes'] = $this->_snippetHandler->getRatedSnippetsByUser($id, 1);
        $this->_data['dislikes'] = $this->_snippetHandler->getRatedSnippetsByUser($id, 0);
        $this->_data['comments'] = $this->_snippetHandler->getCommentedSnippetByUser($id);
    }

    /**
     * @param $id User id
     */
    private function showCreatedSnippets($id) 
    {
        //Get snippets created by User
        $createdSnippets = $this->_snippetHandler->getSnippetsByUser($id);
        $this->_data['content'] = $this->_profileView->createdSnippets($createdSnippets);
    }
    
    /**
     * @param $id User id
     */
    private function showCommentedSnippets($id) 
    {
        //Hämtar snippets som användaren har kommenterat
        $commentedSnippets = $this->_snippetHandler->getCommentedSnippetByUser($id);
        $this->_data['content'] = $this->_profileView->commentedSnippets($commentedSnippets);
    }
    
    /**
     * @param $id User id
     */
    private function showLikedSnippets($id) 
    {
        //Show liked snippets by user
        $likedSnippets = $this->_snippetHandler->getRatedSnippetsByUser($id, 1);
        $this->_data['content']  = $this->_profileView->likedSnippets($likedSnippets);
    }

    /**
     * @param $id User id
     */
    private function showDislikedSnippets($id) 
    {
        //Show disliked snippets by user
        $dislikedSnippets = $this->_snippetHandler->getRatedSnippetsByUser($id, 0);
        $this->_data['content']  = $this->_profileView->dislikedSnippets($dislikedSnippets);
    }

    /**
     * @param $id User id
     */
    private function showSettingsPage($id, $apiKey, $user) 
    {
        if(AuthHandler::isOwner($user->getEmail()) || AuthHandler::isAdmin()) {
            $roles = $this->_userHandler->getAllRoles();
            $this->_data['content'] = $this->_profileView->settings($apiKey, $roles, $user->getRole());
            //if user tries to change role
            if($roleId = $this->_profileView->isChangeUserRole()) {
                $userEmail = $this->_profileView->getUser();
                //Användaren som ska byta roll
                $tempUser = $this->_userHandler->getUserByEmail($userEmail);
                $this->_userHandler->changeUserRole($user->getId(), $roleId);
            }
        } else {
            $this->_data['content'] = $this->_profileView->settings($apiKey);
        }
    }

    /**
     *Search for a user
     */
    private function showUserSearch() 
    {
        //Search for user 
        $users = null;
        if($query = $this->_profileView->doSearch()) {
            $users = $this->_userHandler->searchUser($query);
        }
        $this->_data['content'] = $this->_profileView->searchForUsers($users);
    }

    /**
     * change user role for a
     */
     private function changeUserRole(User $user)
     {
        if($user->isAdmin() || $user->isOwner()) {
            if($this->_profileView->changingSuerRole()) {
                $role = $this->_profileView->GetUserRole();
                $this->_userHandler->changeUserRole($id, $role);
            }
        }
     }
}