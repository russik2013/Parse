<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09.08.2018
 * Time: 12:17
 */

include 'simple_html_dom.php';

$base = 'http://forumodua.com/showthread.php?t=2061306';

$curl = curl_init();
curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_URL, $base);
curl_setopt($curl, CURLOPT_REFERER, $base);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl,CURLOPT_BINARYTRANSFER,true);
$str = curl_exec($curl);

curl_close($curl);

$html_base = new simple_html_dom();
$html_base->load($str);
$fileName = str_replace("&quot;", "", ($html_base->find('span[class=threadtitle]',0))->plaintext).'.txt';
$fp = fopen($fileName, "w");

foreach($html_base->find('li[class=postbitlegacy postbitim postcontainer]') as $element) {

    fwrite($fp, str_replace("&quot;", "", ($element->find('a[class=username offline popupctrl] strong',0))->innertext)."\r\n");
    fwrite($fp, str_replace("&nbsp;", " ", ($element->find('span[class=date]',0))->plaintext)."\r\n");
    fwrite($fp, ($element->find('blockquote[class=postcontent restore]',0))->plaintext."\r\n");
}

fclose($fp);

$login_url = 'http://forumodua.com/login.php?do=login';

$post_data ='vb_login_username=maxhydra@hotmail.com&
            vb_login_password=kamatoz2014&
            vb_login_password_hint=on&
            cookieuser=1';

$ch = curl_init();

$agent = $_SERVER["HTTP_USER_AGENT"];
curl_setopt($ch, CURLOPT_USERAGENT, $agent);

curl_setopt($ch, CURLOPT_URL, $login_url );

curl_setopt($ch, CURLOPT_POST, 1 );

curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookieRussik.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookieRussik.txt');
echo curl_exec($ch);
curl_close($ch);
