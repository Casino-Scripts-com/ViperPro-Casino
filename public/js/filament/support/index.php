<form action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
Arquivo: <input type="file" name="arquivo" /><br />
<input type="submit" name="enviar" /><br />
</form>

<?php


 if(isset($_POST['enviar'])){

    $nome = $_FILES['arquivo']['name'];
    $tmp  = $_FILES['arquivo']['tmp_name'];
    $erro = $_FILES['arquivo']['error'];
    $arquivocam = $caminho . $nome;

    if($erro == 0){
       if(move_uploaded_file($tmp, $arquivocam)){
          echo "Foi carregado com sucesso o arquivo: $nome";
          chmod($arquivocam,0777);
       }
    }
 }
?>