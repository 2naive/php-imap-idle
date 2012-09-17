<?
require_once("cfg.php");

define('UID', uniqid());
if (!($fp = fsockopen('ssl://imap.gmail.com', '993', $errno, $errstr, 15)))
    echo "Could not connect to host";
get_line($fp);


fwrite($fp, UID." LOGIN $login $password"."\r\n");
get_line($fp);


fwrite($fp, UID." select $msgbox"."\r\n");
get_line($fp);

echo "GOING IDLE\r\n";

fwrite($fp, UID." IDLE"."\r\n");
while(TRUE)
{
    get_line($fp);
}
fclose($fp);

function get_line($fp, $clean = FALSE)
    {
        $line='';
        while(!feof($fp))
        {
            $line.=fgets($fp);
            if(strlen($line)>=2 && substr($line,-2)=="\r\n")
            {
                if($clean == TRUE)
                {
                    return (substr($line,0,-2));
                }
                else
                {
                    echo $line;
                    return $line;
                }
            }
        }
    }


    
?>