<html>

<head>
   <meta charset="utf-8">
   <title>Lista Pessoas</title>  
   <link href="css/list.css" rel="stylesheet" type="text/css" 
   media="screen"/>
</head>

<body>
  <table border=1>
  <thead>
    <tr>
        <td></td>
        <td></td>
        <td>id</td>
        <td>Nome</td>
        <td>Endereço</td>
        <td>Bairro</td>
        <td>Tel</td>
        <td>Email</td>
        <td>id_cidade</td>
    </tr>
  </thead>

  <tbody>
    <?php 
       $conn = pg_connect('host=localhost port=5433 dbname=postgres
       user=postgres password=123');

      $result =  pg_query($conn,'SELECT * FROM pessoa ORDER BY id');


      
          // fetch_assoc retornar em vetor 
      while ($row = pg_fetch_assoc($result)) 
      {
        //print $row['codigo'] . '-' . $row['nome'] . '<br>';
         $id = $row['id'];
         $nome =$row['nome'];
         $end =$row['endereco'];
         $bairro =$row['bairro'];
         $tel =$row['telefone'];
         $email =$row['email'];
         $id_cidade =$row['id_cidade'];
       //  $output .= "<option value='{$id}'>$nome</option>";
          print '<tr>';
        print "<td> 
        <a href='form_edit.php?id={$id}'>
        <img src='edit_icon.svg' style='width:17px'> 
         </a>
         </td>";
        print "<td> 
        <a href='form_delete.php?id={$id}'>
        <img src='delete_icon.svg' style='width:17px'> 
        </a>
        </td>";
        print "<td>{$id}</td>";
        print "<td>{$nome}</td>";
        print "<td>{$end}</td>";
        print "<td>{$bairro}</td>";
        print "<td>{$tel}</td>";
        print "<td>{$email}</td>";
        print "<td>{$id_cidade}</td>";

        print '</tr>';
      }
 
    ?>
  </tbody>
  </table>
  <button onclick="window.location='form.php'">
    <img src="button.svg" alt="" style="width: 80%;height: 2%;" > Add
  </button>

</body>

</html>