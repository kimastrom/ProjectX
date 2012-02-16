<?php
class MailView
{
    public function mailView()
    {
        $html = '<div class="mail">
            		<form id="formail" action="" method ="post">
            			<label>Your mail :</label>
            			<input type="text" name="mail" id="mail" />
            			<input type="submit" value="send mail" id="sendmail" name="sendmail" />
            		</form>
                    <div id="response">
                    </div>
        	</div>';

        return $html;
    }
}
