<?
# @todo
# recursive line checking based on lenght
# check for response RFC
# fread 4096 except mails
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
        get_line($fp);
        get_line($fp);
        get_line($fp);
        get_line($fp);

while(TRUE)
{
    $response = get_line($fp);
    if(preg_match('/([\d]+) EXISTS/', $response, $matches))
    {
        fwrite($fp, "DONE\r\n");
        get_line($fp);

        fwrite($fp, UID." FETCH ".$matches[1]." BODY[TEXT]\r\n");
        get_line($fp);

        break;
    }
    
}

fclose($fp);

function get_line($fp, $clean = FALSE)
    {
    /*
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
    
    /*
        $line = fgets($fp, 4096);
        var_dump(feof($fp));
        echo strlen($line);
        echo $line;
        return $line;
        
    */
 
        $line = fgets($fp, 4096);
        echo $line;
        return $line;
    }  
?>