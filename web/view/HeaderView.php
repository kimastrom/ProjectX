<?php

class HeaderView
{
    /**
     * @param $name string Name of user
     * @param $userPic string url of user avatar
     * @return string View of header with logged in layout
     */
    public function inloggedHeader($name, $userPic, $email)
    {
        $html = "<header id='mainHeader'>
                    
                        <nav id='mainNav'>
                            <ul id='siteNav'>
                                <li>
                                    <a class='border-right' href='index.php'>Home</a>
                                </li>
                                <li>
                                    <a class='border-right' href='?page=addsnippet'>Add snippet</a> 
                                </li>
                                <li>
                                    <a class='border-right' href='#'>News</a> 
                                </li>
                                <li>
                                    <a class='border-right' href='#'>Downloads</a> 
                                </li>
                                <li>
                                    <a href='#'>About</a>
                                </li>
                                <li class ='right' id='logout-topbar'>
                                    <a href='?logout=true'>Sign out</a>
                                </li>
        
                                <li class='right'>
                                    <a href='/profile'>$name</a>
                                </li>
                                <li class='login'>
                                    <img id='topAvatar' src='$userPic' alt='as' />
                                </li>
                            </ul>
                        </nav>
                        
                </header>";

        return $html;
    }

    /**
     * @return string View of header when user not logged in
     */
    public function notLoggedInHeader()
    {
        $html = "<header id='mainHeader'>
                    <nav id='mainNav'>
                        <ul id='siteNav'>
                            <li>
                                <a class='border-right' href='index.php'>Home</a> 
                            </li>
                            <li>
                                <a  class='border-right' href='#'>News</a> 
                            </li>
                            <li>
                                <a  class='border-right' href='#'>Downloads</a> 
                            </li>
                            <li>
                                <a class='no-border' href='#'>About</a>
                            </li>
                            <li class='right'>
                                <a class='janrainEngage' href='#'>Sign in</a>
                            </li>
                        </ul>
                    </nav>
                </header>";

        return $html;
    }

}
