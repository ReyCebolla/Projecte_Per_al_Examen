<?php

include './views/loginForm.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Chat</title>

<script type="text/javascript" src="./assets/js/jquery-1.7.2.min.js"></script>

<link href="./assets/css/procesa.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css"/>

<script src="./assets/js/ajaxs.js?v=<?php echo time(); ?>"></script>

<body>
</head>

<?php

            
            
            require './views/errorUsuariPassword.php';
            
            loginForm();
            require './views/adminInterficie.php';


?>
</body>
</html>
