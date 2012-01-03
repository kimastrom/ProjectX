<?php
require_once dirname(__file__) . '/../model/Captcha.php';

class CommentView
{
    /**
     * CommentView::doCommentForm()
     * html form for adding a new comment
     * @return String
     */
    public function doCommentForm()
    {
        $captcha = new Captcha();
        $form = "<div id='comment'>
                    <h3>Post a comment</h3>
                    <form action='' method='POST'>
                        <input type='text' name='commentAuthor' value='6'/>
                        <textarea name='commentText' maxlength='1500' placeholder='Your comment'></textarea>
                        <label for='secure'></label>
                        <img src='secure.jpg' alt='Captcha image'/>
                        <input type='text' name='secure' placeholder='Are you a human?' />
                        <input type='submit' name='submitComment' value='Post comment'/>
                    </form>
                </div>";
        return $form;
    }

    /**
     * CommentView::showAllCommentsForSnippet()
     * html that shows all comments taht was added for a snippet
     * @return String
     * @parram array of the Comment object
     */
    public function showAllCommentsForSnippet($comments)
    {
        $message = "";
        if (!empty($comments)) {
            for ($i = 0; $i < count($comments); $i++) {
                $message .= "<div class='comments'>";
                $message .= "<p class='snippet-author'>" . $comments[$i]->getUser()->getUserName() . "</p>";
                $message .= "<p class='date'>2012-01-01</p>";
                $message .= "<p class='text'>" . $comments[$i]->getCommentText() . "</p>";
                $message .= "<a onclick=\"javascript: return confirm('Vill du verkligen ta bort kommentar? [" . $comments[$i]->getCommentId() . "]')\" href='index.php?page=listsnippets&snippet=" . $comments[$i]->getSnippetId() . "&controller=commentcontroller&deleteComment=" . $comments[$i]->getCommentId() . "'>Radera</a> ";
                $message .= "<a onclick=\"javascript: return confirm('Vill du verkligen editera kommentar? [" . $comments[$i]->getCommentId() . "]')\" href='index.php?page=listsnippets&snippet=" . $comments[$i]->getSnippetId() . "&controller=commentcontroller&editComment=" . $comments[$i]->getCommentId() . "'>Redigera</a>";
                $message .= "</div>";
            }
        } else {
            $message .= "<p>There is no comments for this snippet.</p>";
        }

        return $message;
    }

    /**
     * CommentView::editComment()
     * html taht allows to edit a comment text
     * @param Comment object
     * @return String
     */
    public function editComment($comment)
    {
        if ($comment) {
            $form = "<div id='comment'>
                        <h3>Update your comment</h3>
                        <form action='' method='POST'>
                            <input type='text' name='commentAuthor' placeholder='Name' value='" . $comment->getUser()->getUserName() . "' readonly='readonly'/>
                            <textarea name='commentText' maxlength='1500' placeholder='Your comment'>" . $comment->getCommentText() . "</textarea>
                            <input type='submit' name='updateComment' value='Update comment'/>
                        </form>
                    </div>";
        } else {
            $form = "The comment you tries to edit does not exist.";
        }
        return $form;
    }

    /**
     * CommentView::triedToSubmitComment()
     *
     * @return true if user is trying to add a new comment
     */
    public function triedToSubmitComment()
    {
        if (isset($_POST['submitComment'])) {
            return true;
        }
        return false;
    }

    /**
     * CommentView::getCommentText()
     *
     * @return String that is the text of the comment
     */
    public function getCommentText()
    {
        if (isset($_POST['commentText'])) {
            return trim($_POST['commentText']);
        }
        return false;
    }

    /**
     * CommentView::getAuthorId()
     *
     * @return int, id of the User
     */
    public function getAuthorId()
    {
        if (isset($_POST['commentAuthor'])) {
            return trim($_POST['commentAuthor']);
        }
        return false;
    }

    /**
     * CommentView::getCaptchaAnswer()
     *
     * @return
     */
    public function getCaptchaAnswer()
    {
        if (isset($_POST['secure'])) {
            return trim($_POST['secure']);
        } 
        
        return false;
    }

    /**
     * CommentView::triesToRemoveComment()
     *
     * @return true if user is trying to delete a comment
     */
    public function triesToRemoveComment()
    {
        if (isset($_GET["deleteComment"])) {
            return true;
        }
        return false;
    }

    /**
     * CommentView::whichCommentToDelete()
     *
     * @return int, id of the comment that is going to be deleted
     */
    public function whichCommentToDelete()
    {
        if (isset($_GET["deleteComment"])) {
            return urldecode($_GET["deleteComment"]);
        }
        return false;
    }

    /**
     * CommentView::triesToEditComment()
     *
     * @return true if the user is trying to edit a comment
     */
    public function triesToEditComment()
    {
        if (isset($_GET["editComment"])) {
            return true;
        }
        return false;
    }

    /**
     * CommentView::whichCommentToEdit()
     *
     * @return int, id of the comment that user wants to edit
     */
    public function whichCommentToEdit()
    {
        if (isset($_GET["editComment"])) {
            return urldecode($_GET["editComment"]);
        }
        return false;
    }

    /**
     * CommentView::triesToUpdateComment()
     *
     * @return true if user wants to update comment
     */
    public function triesToUpdateComment()
    {
        if (isset($_POST["updateComment"])) {
            return true;
        }
        return false;
    }

    /**
     * CommentView::whichSnippetToComment()
     *
     * @return int, id of the snippet for which user wants to add a new comment
     */
    public function whichSnippetToComment()
    {
        if (isset($_GET["snippet"])) {
            return urldecode($_GET["snippet"]);
        }
        return false;
    }

}
