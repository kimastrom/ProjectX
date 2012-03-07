<?php

class ProfileView
{

    public function profile($avatar, $name, $data, $user)
    {
        $html = $this->doProfileMenu($data['isAdmin'], $data['isOwner'], $data['email']);

        $html .= "
                <h3>Hi there " . $name . "</h3><br>
                <img src='" . $avatar . "' alt='User' />
                <div id='stats'>
                    <p>Created snippets:" . count($data['snippets']) . "</p>
                    <p>Commented snippets: " . count($data['comments']) . "</p>
                    <p>Total likes: " . count($data['likes']) . "</p>
                    <p>Total dislikes: " . count($data['dislikes']) . "</p>
                    <p>User role: " . $user->getRoleName() . "</p>
                </div>
                <br />
                <div id='userActivity'>";

        $html .= $data['content'];

        $html .= '</div>';
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
        foreach ($createdSnippets as $snippet) {
            $html .= "<li><a href='?page=listsnippets&amp;snippet=" . $snippet->getID() . "'>" . $snippet->getTitle() . "</a> - (" . $snippet->getLanguage() . ")</li>";
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
                <ul>
                <li><a href='?username=" . $email . "&amp;p=created'>Created snippets</a></li>
                <li><a href='?username=" . $email . "&amp;p=commented'>Commented Snippets</a></li>
                <li><a href='?username=" . $email . "&amp;p=liked'>Liked snippets</a></li>
                <li><a href='?username=" . $email . "&amp;p=disliked'>DislikedSnippets</a></li>";
                if($isOwner || $isAdmin) {
                    $html .= "<li><a href='?username=" . $email . "&p=settings'>Settings</a></li>";
                }
                
                if($isAdmin) {
                    $html .= "<li><a href='?username=" . $email . "&p=search'>Search for users</a></li>";
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
        $html = '<span>api key ' . $apiKey . ' - </span>';
        $html .= "<a href='/profile?username=" . $username . "&p=settings&amp;api_key=generate'>Generate new</a>";
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
                        <input type='submit' name='changerole' />
                    </form>";
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
