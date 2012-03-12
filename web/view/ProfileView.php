<?php

class ProfileView
{

    public function profile($avatar, $name, $data, $user)
    {
        $html = $this->doProfileMenu($data['isAdmin'], $data['isOwner'], $data['email']);

        $html .= "
                <div id='profile-stats'>
                    <h3>Hi there " . $name . "</h3><br />
                    <img src='" . $avatar . "' alt='User' /> <br /><br />
                        <p>Created snippets:" . count($data['snippets']) . "</p>
                        <p>Commented snippets: " . count($data['comments']) . "</p>
                        <p>Total likes: " . count($data['likes']) . "</p>
                        <p>Total dislikes: " . count($data['dislikes']) . "</p>
                        <p>User role: " . $user->getRoleName() . "</p>
                        <p>Api-key: " . $user->getApiKey() . "</p>
                        <p>UserID: " . $user->getId() . "</p>
                </div>
                <div id='user-activity'>";

        $html .= $data['content'];

        $html .= "</div><div class='clear'></div>";
        return $html;
    }

    public function likedSnippets($likedSnippets)
    {
        $html = "<h3>Liked snippets</h3>
                    <ul>";

        foreach ($likedSnippets as $snippet) {
            $html .= "<li><a href='?page=listsnippets&amp;snippet=" . $snippet->getID() . "'>" . $snippet->getTitle() . "</a> - (" . $snippet->getLanguage() . ")</li>";
        }
        $html .= "</ul>";
        return $html;
    }

    public function dislikedSnippets($dislikedSnippets)
    {
        $html = "<h3>Disliked snippets</h3>
                    <ul>";
        foreach ($dislikedSnippets as $snippet) {
            $html .= "<li><a href='?page=listsnippetssnippet=" . $snippet->getID() . "'>" . $snippet->getTitle() . "</a> - (" . $snippet->getLanguage() . ")</li>";
        }
        $html .= "</ul>";
        return $html;
    }

    public function createdSnippets($createdSnippets)
    {
        $html = "<h3>Created snippets</h3>
                    <ul>";
        if($createdSnippets) {
            foreach ($createdSnippets as $snippet) {
                $html .= "<li><a href='?page=listsnippets&amp;snippet=" . $snippet->getID() . "'>" . $snippet->getTitle() . "</a> - (" . $snippet->getLanguage() . ")</li>";
            }
        } else {
            $html .= 'You have no created snippets';
        }
        $html .= "</ul>";
        return $html;
    }

    public function commentedSnippets($commentedSnippets)
    {
        $html = "<h3>Commented snippets</h3>
                    <ul>";
        foreach ($commentedSnippets as $snippet) {
            $html .= "<li><a href='?&page=listsnippets&snippet=" . $snippet['id'] . "'>" . $snippet['title'] . '</a><br />' . $snippet['comment'] . '</li>';
        }
        $html .= "</ul>";
        return $html;
    }
    
    public function doProfileMenu($isAdmin, $isOwner, $email) {
        $html = "    
                <ul id='profile-menu'>
                <li><a href='/?page=profile&amp;p=created&amp;username=" . $email . "'>Created snippets</a></li>
                <li><a href='/?page=profile&amp;p=commented&amp;username=" . $email . "'>Commented snippets</a></li>
                <li><a href='/?page=profile&amp;p=liked&amp;username=" . $email . "'>Liked snippets</a></li>
                <li><a href='/?page=profile&amp;p=disliked&amp;username=" . $email . "'>Disliked snippets</a></li>";
                if($isOwner || $isAdmin) {
                    $html .= "<li><a href='/?page=profile&amp;p=settings&amp;username=" . $email . "'>Settings</a></li>";
                }
                
                if($isAdmin) {
                    $html .= "<li><a href='/?page=profile&amp;p=search&amp;username=" . $email . "'>Search for users</a></li>";
                }
                $html .= "</ul>";
        return $html;
    }
    
    public function searchForUsers($users = null) {
        $html =  "<form action='/profile?p=search' method='POST' name='usersearch'>
            <input type='text' name='q' />
            <input type='submit' name'searchuser' value='search' />
        </form>";

        if($users) {
            $html .= "<ul>";
            foreach ($users as $user) {
                $html .= "<li><a href='?username=" . $user->getUsername() . "'>" . $user->getName() . "</a></li>";
            }
            $html .= "</ul>";
        } else {
            if($this->doSearch()){
                $html .= "<p>No matches found.</p>";
            }
        }

        return $html;
    }
    
    public function settings($apiKey, $roles = null, $currentRole = null) {
        $username = $this->getUser();
        $html = '<h3>Settings</h3>';
        $html .= "<h4>This is your api-key <img class='info' data-info='Use the api-key to verify yourself in the desktop app' src='/content/image/info.png' alt='info'/></h4>";
        $html .= '<span>' . $apiKey . ' - </span>';
        $html .= "<a href='/profile?username=" . $username . "&p=settings&amp;api_key=generate'>Generate new</a>";
        $html .= '<h4>This is your user role - change it if you want..</h4>';
        if($roles != null) {
            $html .= "<form action='#' method='POST' >
                        <select name='role'>";
                            foreach ($roles as $k => $value) {
                                if($k == $currentRole) {
                                    $html .= "<option selected='selected' value='" . $k . "'>" . $value . "</option>";
                                } else {
                                    $html .= "<option value='" . $k . "'>" . $value . "</option>";
                                }
                            }
            $html .= "</select>
                        <input type='submit' value='save changes' name='changerole' />
                    </form>";

            $html .= '<h4>These accounts are connected to your login</h4>';
            $html .= '<h4>Delete your account and remove all your connected accounts</h4>';
        }
        return $html;
    }

    public function isUpdateProfile()
    {
        if (isset($_POST['update'])) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getPage()
    {
        if(isset($_GET['p'])) {
            return $_GET['p'];
        }
        return false;
    }

    public function doSearch()
    {
        if(isset($_POST['q'])) {
            return $_POST['q'];
        }
        return false;
    }

    public function isChangeUserRole() {
        if(isset($_POST['changerole'])) {
            return $_POST['role'];
        }
        return false;
    }

    public function getUser() {
        if(isset($_GET['username'])) {
            return $_GET['username'];
        }
        return false;
    }
}

