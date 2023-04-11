<?php 
class Questionnaire {
    
    private $nom;
    private $listQuest;
    private $nbquestion;
    private $id;

    function __construct($no,$nbquestion,$id){
        $this->nom = $no;
        $this->listQuest = array();
        $this->nbquestion = $nbquestion;
        $this->id = $id;
    }

    public function creerQuestionnaire($titreq,$nbQ,$idU){
        require_once("connect.php");
        $dsn="mysql:dbname=".BASE.";host=".SERVER;
        try{
            $connexion=new PDO($dsn,USER,PASSWD);
        }
        catch(PDOException $e){
            printf("Échec de la connexion : %s\n", $e->getMessage());
            exit();
        }
        $countQuestionnaire="select MAX(idQuestionnaire) from QUESTIONNAIRE";
        foreach ($connexion->query($countQuestionnaire) as $val){
            $count = strval(intval($val[0])+1);
        }
        $sql = "insert into QUESTIONNAIRE values (:id,:titre,:nb)";
        $dsn="mysql:dbname=".BASE.";host=".SERVER;
        $connexion=new PDO($dsn,USER,PASSWD);
        $data = $connexion->prepare($sql);
        $data->bindParam('id', $count);
        $titre = $titreq;
        $nb = $nbQ;
        $data->bindParam('titre', $titre);
        $data->bindParam('nb', $nb);
        $data->execute();

        $sql = "insert into CONSULTER values (:id,:nb)";
        $dsn="mysql:dbname=".BASE.";host=".SERVER;
        $connexion=new PDO($dsn,USER,PASSWD);
        $data = $connexion->prepare($sql);
        $data->bindParam('id', $count);
        $id = $idU;
        $nb = $count;
        $data->bindParam('id', $id);
        $data->bindParam('nb', $nb);
        $data->execute();
    }

    public function modifNom($titre,$id){
        require_once("connect.php");

        $sql = "UPDATE QUESTIONNAIRE set nomQuestionnaire=:nomQUESTIONNAIRE where idQuestionnaire=:idQUESTIONNAIRE";
        $dsn="mysql:dbname=".BASE.";host=".SERVER;
        $connexion=new PDO($dsn,USER,PASSWD);
        $data = $connexion->prepare($sql);
        $data->bindParam('nomQUESTIONNAIRE', $titre);
        $data->bindParam('idQUESTIONNAIRE', $id);
        $data->execute();

    }

    public function getID(){
        return $this->id;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getQuestions(){
        return $this->listQuest;
    }

    public function getNbQuestion(){
        return $this->nbquestion;
    }

    public function affiche(){
        for($i = 0; $i < count($this->listQuest); $i++){
            $this->listQuest[$i]->affiche($i);
        }
    }

    public function addQuest($quest){
        array_push($this->listQuest, $quest);
    }

    

    public function supprimer($idQ){
        require_once("connect.php");
        $sql = "DELETE FROM CONSULTER where idQuestionnaire =:id ";
        $dsn="mysql:dbname=".BASE.";host=".SERVER;
        $connexion=new PDO($dsn,USER,PASSWD);
        $id = $idQ;
        $data = $connexion->prepare($sql);
        $data->bindParam('id', $id);
        $data->execute();

        $sql = "Select * FROM QUESTION where idQuestionnaire =:id ";
        $dsn="mysql:dbname=".BASE.";host=".SERVER;
        $connexion=new PDO($dsn,USER,PASSWD);
        $id = $idQ;
        $data = $connexion->prepare($sql);
        $data->bindParam('id', $id);
        $data->execute();
        $val = array();
        while ($valeur = $data->fetch(PDO::FETCH_ASSOC)) {
            $val[] = $valeur;
        }
        // print_r($val);

        foreach($val as $elem){
            $sql = "DELETE FROM REPONSE where idQuestion=:id ";
            $dsn="mysql:dbname=".BASE.";host=".SERVER;
            $connexion=new PDO($dsn,USER,PASSWD);
            $data = $connexion->prepare($sql);
            $data->bindParam('id', $elem['idQuestion']);
            $data->execute();
        }


        $sql = "DELETE FROM QUESTION where idQuestionnaire =:id ";
        $dsn="mysql:dbname=".BASE.";host=".SERVER;
        $connexion=new PDO($dsn,USER,PASSWD);
        $id = $idQ;
        $data = $connexion->prepare($sql);
        $data->bindParam('id', $id);
        $data->execute();

        $sql = "DELETE FROM QUESTIONNAIRE where idQuestionnaire =:id ";
        $dsn="mysql:dbname=".BASE.";host=".SERVER;
        $connexion=new PDO($dsn,USER,PASSWD);
        $id = $idQ;
        $data = $connexion->prepare($sql);
        $data->bindParam('id', $id);
        $data->execute();
    }


    

   

}