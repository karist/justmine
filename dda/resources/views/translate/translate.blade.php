<html>
<head>
<title>Hasil terjemahan</title>
<style type="text/css">
body {
      background-color : #FFFFFF;
      font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
      color : #000088;
      margin: 5px;
      }
</style>
</head>

<body>
<input type="text" name="teks" id = "teks" value="{{ $teks }}">
<input type="text" name="tujuan" id = "tujuan" value="{{ $tujuan }}">
<?php
class GoogleTranslateApi{

    var $BaseUrl = 'http://ajax.googleapis.com/ajax/services/language/translate';
    var $FromLang = 'id';
    var $ToLang = '';
    var $Version = '1.0';
    
    var $CallUrl;
    
    var $Text = '';
    
    var $TranslatedText;
    var $DebugMsg;
    var $DebugStatus;
    
    function GoogleTranslateApi(){
        $this->CallUrl = $this->BaseUrl . "?v=" .
        $this->Version . "&q=" . urlencode($this->Text) .
        "&langpair=" . $this->FromLang . "%7C" . $this->ToLang;
    }
    
    function makeCallUrl(){
        $this->CallUrl = $this->BaseUrl . "?v=" .
        $this->Version . "&q=" . urlencode($this->Text) .
        "&langpair=" . $this->FromLang . "%7C" . $this->ToLang;
    }
    
    function translate($text = ''){
        if($text != ''){
            $this->Text = $text;
        }
        $this->makeCallUrl();
        if($this->Text != '' && $this->CallUrl != ''){
            $handle = fopen($this->CallUrl, "rb");
            $contents = '';
            while (!feof($handle)) {
            $contents .= fread($handle, 8192);
            }
            fclose($handle);
            
            $json = json_decode($contents, true);
            
            if($json['responseStatus'] == 200){ //Request berhasil
                $this->TranslatedText = $json['responseData']['translatedText'];
                $this->DebugMsg = $json['responseDetails'];
                $this->DebugStatus = $json['responseStatus'];
                return $this->TranslatedText;
            } else { //Ada kesalahan
                return false;
                $this->DebugMsg = $json['responseDetails'];
                $this->DebugStatus = $json['responseStatus'];
            }
        } else {
            return false;
        }
    }
}
$translate = new GoogleTranslateApi;
$to = $tujuan;
// $to=$_POST['tujuan'];

$translate->FromLang = 'id';
$translate->ToLang = $to;
switch ($to)
{
  case 'en':$tolang="Inggris";break;
  case 'it':$tolang="Italia";break;
  case 'es':$tolang="Spanyol";break;
  case 'fr':$tolang="Perancis";break;
}
// $teks = $teks;
echo $teks;
echo '<center>Google menerjemahkan <br>
      <b>"'.$teks.'"</b><br><br>
      ke dalam bahasa '.$tolang.' menjadi: <br><b>"';
echo $translate->translate($teks).'"</b>';

?>

</body>

</html>