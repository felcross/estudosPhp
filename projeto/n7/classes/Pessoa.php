<?php
class Pessoa
{
  private static $conn;
   public static function getConnection()
   {
      if(empty(self::$conn)){
      $init = parse_ini_file('config/config.ini');
      $name = $init['name'];
      $host = $init['host'];
      $user = $init['user'];
      $password = $init['password'];
      $port = $init['port'];
      self::$conn = new PDO("pgsql:dbname={$name};user={$user};
        password={$password};host={$host};port={$port}");
      self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }
                                                                        
      return self::$conn;
   }


   public static function find($id)
   {

      $conn = self::getConnection();
      $result = $conn->prepare("SELECT * FROM pessoa WHERE id = :id ");
      $result->execute([':id' => $id]);
      return $result->fetch();
   }
   public static function delete($id)
   {

       $conn = self::getConnection();

      $result = $conn->prepare("DELETE FROM pessoa WHERE id = :id");
      $result->execute([':id' => $id]);
      return $result;
   }
   public static function all()
   {

      $conn = self::getConnection();

      $result = $conn->query("SELECT * FROM pessoa ORDER BY id");
      return $result->fetchAll();
   }
   public static function save($pessoa)
   {
  
      $conn = self::getConnection();
      print $pessoa['id'] . '<br>';
      print $pessoa['id_cidade']. '<br>' ;
      if (empty($pessoa['id'])) {
        /* $sql = "INSERT INTO pessoa ( id , nome, endereco ,bairro ,telefone , email, id_cidade ) VALUES (  
            :id,
            :nome,
            :endereco,
            :bairro,
            :telefone,
            :email,
            :id_cidade )";*/

/*$sql = "INSERT INTO pessoa (nome,endereco,bairro,telefone, email, id_cidade) 
VALUES (
':nome',
':endereco',
':bairro',
':telefone',
':email',
':id_cidade')";*/


   // $sql = "INSERT INTO pessoa (nome,endereco,bairro,telefone, email, id_cidade) VALUES (:nome, :endereco, :bairro, :telefone, :email, :id_cidade)";
           // print "$sql <br>";
      } else {
         $sql = "UPDATE pessoa SET 
            nome =:nome,
            endereco =:endereco,
            bairro   =:bairro,
            telefone  =:telefone,
            email   = :email,
            id_cidade =:id_cidade
            WHERE id = :id";
           // print "$sql <br>";
      }
      print "$sql <br>";
      $result =  $conn->prepare($sql);
       $result->execute([':id' => $pessoa['id'],
                       ':nome' => $pessoa['nome'],
                       ':endereco' => $pessoa['endereco'],
                       ':bairro' => $pessoa['bairro'],
                       ':telefone' => $pessoa['telefone'],
                       ':email' => $pessoa['email'],
                       ':id_cidade' => $pessoa['id_cidade']]);

   }
}
