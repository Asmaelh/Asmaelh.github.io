<!DOCTYPE html>
<?php
require_once('DiDom/ClassAttribute.php');
require_once('DiDom/Document.php');
require_once('DiDom/Element.php');
require_once('DiDom/Encoder.php');
require_once('DiDom/Errors.php');
require_once('DiDom/Query.php');
require_once('DiDom/StyleAttribute.php');
require_once('DiDom/Exceptions/InvalidSelectorException.php');
use DiDom\ClassAttribute;
use DiDom\Document;
use DiDom\Element;
use DiDom\Encoder;
use DiDom\Errors;
use DiDom\Query;
use DiDom\StyleAttribute;
use DiDom\Exceptions\InvalidSelectorException; 
?>
<html lang='ru'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Расписание</title>
    <style>
    p {
        color: #4a4a4a;
        font-size: 14px;
        margin: 0;
    }
	.day {color: #ff0000;}
	.text {color: #006400;}
	.article {font-weight: bold;}
	.name {color: #800080;}
	span.article {color: #4a4a4a; font-weight: bold;}
	
    </style>
</head>

<body>
<?php
$url = "https://www.vioms.ru/email_lists/151";
$document = new Document($url, true);
$ltable = $document->find('tbody');
$links = $ltable[0]->find("//a[contains(text(),'Расписание лекций')]", Query::TYPE_XPATH);
$l1 = $links[0]->first('a::attr(href)');
$links = $ltable[0]->find("//a[contains(text(),'Воскресная')]", Query::TYPE_XPATH);
$l2 = $links[0]->first('a::attr(href)');
$url = "https://www.vioms.ru".$l1."/full";
$document = new Document($url, true);
$titles = $document->find('p');
echo "<p class='article'>".$titles[1]->text()."</p>";
echo "<br>";
$tables = $document->find('table');
$trs = $tables[1]->find('tr');
array_shift($trs);
echo "<div class='block__row'><div class='lectures'>";
foreach($trs as $tr)
{
    $tds = $tr->find('td');
    echo "<p class='day'>".$tds[0]->text()."</p>";
	echo "<p class='text'>".$tds[1]->text()."<span class='article'>".html_entity_decode(str_replace("&nbsp;", "", htmlentities($tds[2]->text(), null, 'utf-8')))."</span></p>";
	echo "<p class='name'>".$tds[3]->text()."</p>";
    echo "<br>";
}
?></div>
<div class='lectures_bg'>
<?php
$dir = $document->first('[dir]');
$dirps = $dir->find('p');
    echo "<p>".$dirps[0]->text()."</p>";
	echo "<p class='article'>".$dirps[1]->text()."</p>";
	echo "<p class='day'>".$dirps[2]->text()."</p>";
	echo "<p class='day'>".$dirps[3]->text()."</p>";
    echo "<br>";
?></div>
<div class='lectures_wskr'>
<?php	
$url = "https://www.vioms.ru".$l2."/full";
$document = new Document($url, true);
$wskr = $document->find('p');
$zam1 = array("&nbsp;", "жмите сюда.");
	echo "<p class='article'>".html_entity_decode(str_replace("&nbsp;", "", htmlentities($wskr[1]->text(), null, 'utf-8')))."</p>";
	echo "<p class='day'>".html_entity_decode(str_replace($zam1, "", htmlentities($wskr[2]->text(), null, 'utf-8')))."</p>";
	echo "<p>".html_entity_decode(str_replace("&nbsp;", "", htmlentities($wskr[3]->text(), null, 'utf-8')))."</p>";
?>
</div>
</div>

</body>

</html>