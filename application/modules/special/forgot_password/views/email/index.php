<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Responsive Meta Tag -->
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
<title><?php echo $starter->_get_lexique('Renouvellement de votre mot de passe.');?></title>
<style type="text/css">
body {
  width: 100%;
  margin: 0;
  padding: 0;
  background-color: #FFFFFF;
}
p, h1, h2, h3, h4 {
  margin-top: 0;
  margin-bottom: 0;
  padding-top: 0;
  padding-bottom: 0;
}
span.preheader {
  display: none;
  font-size: 1px;
}
html {
  width: 100%;
  margin: 0;
  padding: 0;
}
table, tr, td {
  font-size: 14px;
  border: 0;
}

@media only screen and (max-width: 580px) {
.container {
  width: 400px !important;
}
}
@media only screen and (max-width: 420px) {
.container {
  width: 340px !important;
}
}
</style>
</head>

<body width="100%" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#FFFFFF">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td height="50"></td>
  </tr>
</table>

<!-- ////////////     HEADER LOGO     //////////// -->
<table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td>
      <table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" class="container" editable="true" height="70" width="560">
        <tbody>
          <tr>
            <td align="center"><img class="logo" style="width:65px;" src="{HTTP_ROOT}templates/default/content/static/logo.svg" style="margin:0; padding:0; float:left">
                </td>
          </tr>
        </tbody>
      </table></td>
  </tr>
</table>
<!-- ////////////     TEXT     //////////// -->
<table width="100%" editable="true" mc:edit="text" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td>
       <table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" class="container" height="90" width="560" >
        <tbody>
  <tr>
      <td width="25" height="25"></td>
            <td height="25"></td>
            <td width="25" height="25"></td>
  </tr>         
         <!-- TEXTE BOOK -->
          <tr>
      <td width="25"></td>
            <td editable="true" style="font-family:Verdana, Arial, sans-serif; color:#898989; font-size:22px; line-height:30px;font-weight: bold;"><?php echo $starter->_get_lexique('Renouvellement de votre mot de passe pour acc&eacute;der &agrave; Rosalie family');?></td>
      <td width="25"></td>
          </tr>
          
          <!-- ESPACE -->
          <tr>
      <td width="25"></td>
            <td height="30"></td>
      <td width="25"></td>
          </tr>
          
          <!-- TEXTE BOOK -->
          <tr>
      <td width="25"></td>
            <td editable="true" style="font-family:Verdana, Arial, sans-serif; color:#898989; font-size:14px; line-height:22px;text-align:justify;"><br /><?php echo $starter->_get_lexique('Bonjour,') ;?> <br /><br />
        <?php echo $starter->_get_lexique('Veuillez cliquer sur le lien ci-dessous pour obtenir votre mot de passe temporaire :');?><br /></td>
      <td width="25"></td>
          </tr>          
          <!-- BOUTON PRIMAIRE-->
          <tr>
      <td width="25"></td>
            <td  style="font-family:Verdana, Arial, sans-serif; color:#898989; font-size:14px;text-align:right"><br /><a style="color:#00289b; font-weight: bold; text-decoration: underline" href="{PWDLINK}"><?php echo strtoupper($starter->_get_lexique('Renouveler') );?></a></td>
      <td width="25"></td>
          </tr>
          <tr>
      <td width="25"></td>
            <td editable="true" style="font-family:Verdana, Arial, sans-serif; color:#898989; font-size:14px; line-height:22px;text-align:left;"><br />
<?php echo $starter->_get_lexique("N'oubliez pas de modifier votre mot de passe dans votre espace personnel.");?><br /><br />
<?php echo $starter->_get_lexique('A bient&ocirc;t,');?><br /><br />
<?php echo $starter->_get_lexique("L'&eacute;quipe Rosalie family") ;?></td>
      <td width="25"></td>
          </tr>
  <tr>
      <td width="25" height="25"></td>
            <td height="25"></td>
            <td width="25" height="25"></td>
  </tr>
        </tbody>
      </table>
      </td>
  </tr>
</table>

<!-- ////////////     TEXT     //////////// -->
<table width="100%" cellpadding="0" cellspacing="0" border="0" >
  <tr>
    <td>
       <table align="center" bgcolor="#DDDDDD" border="0" cellpadding="0" cellspacing="0" class="container" height="30" style="padding:20px;" width="560">
        <tbody>
          <tr>
            <td  style="font-family:Verdana, Arial, sans-serif; color:#898989; font-size:14px;text-align:right"><a style="color:#898989; text-decoration: none" href="{HTTP_ROOT}"><?php echo $starter->_get_lexique('Connexion') ;?></a></td>
          </tr>
        </tbody>
      </table></td>
  </tr>
</table>

<!-- ////////////     TEXT     //////////// -->
<table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tbody>
    <tr>
      <td height="50"></td>
    </tr>
  </tbody>
</table>
</body>
</html>