<?php
    require_once "./Models/categorias.php";
    require_once "./Models/produtos.php";
    require_once "./Models/vendasModel.php";
    require_once "./Models/clientesModel.php";

    

class CadastroController extends Controller
{
// PRODUTOS
    public function Produto()
    {
        $this->mostrarView('produtos','','','','');
    }
    public function Buscar_Produtos()
    {   
        
        if(@$_POST['dados']){           
            $this->produtos= $this->Produto->getIdProdutos($_POST['dados']);
        }elseif(@$_POST['busca'])
        {
            $this->produtos= $this->Produto->getNomeProdutos($_POST['busca']);
        }
        else{
            
            $this->produtos= $this->Produto->getProdutos();
        
        }       
        echo json_encode($this->produtos);
    }

    public function inserir_Produtos()
    {   
          /* formatos de imagem permitidos */
                $permitidos = array(".jpg",".jpeg",".gif",".png", ".bmp");
                if(isset($_POST)){
                    $nome_imagem    = $_FILES['imagem']['name'];
                    $tamanho_imagem = $_FILES['imagem']['size'];
                    /* pega a extensão do arquivo */
                    $ext = strtolower(strrchr($nome_imagem,"."));
                    /*  verifica se a extensão está entre as extensões permitidas */
                    if(in_array($ext,$permitidos)){
                        /* converte o tamanho para KB */
                        $tamanho = round($tamanho_imagem / 1024);
                        if($tamanho < 1024){ //se imagem for até 1MB envia
                            $nome_atual = md5(uniqid(time())).$ext;
                            //nome que dará a imagem
                            $tmp = $_FILES['imagem']['tmp_name'];
                            //caminho temporário da imagem
                            /* se enviar a foto, insere o nome da foto no banco de dados */
                            if(move_uploaded_file($tmp,ASSETS.$nome_atual))
                                {
                                
                                $this->produtos= $this->Produto->insertProdutos($_POST['descricao'],$_POST['status'],$nome_atual,$_POST['fornecedor'],$_POST['precoVenda'],$_POST['precoCompra'],$_POST['categoria'],$_POST['quantidade']);
                                echo json_encode($this->produtos);
                            }else{
                                echo "Falha ao enviar";
                                
                                }
                        }else{
                            echo "A imagem deve ser de no máximo 1MB";
                            }
                    }else{
                        echo "Somente são aceitos arquivos do tipo Imagem";
                        }
                }else{
                    echo "Selecione uma imagem";
                    exit;
                    }
    }

    public function update_Produtos()
    {   
        /* formatos de imagem permitidos */
        $permitidos = array(".jpg",".jpeg",".gif",".png", ".bmp");
        if(isset($_POST)){
            if($_FILES['imagem']['name']!=''){
            $nome_imagem    = $_FILES['imagem']['name'];
            $tamanho_imagem = $_FILES['imagem']['size'];
            /* pega a extensão do arquivo */
            $ext = strtolower(strrchr($nome_imagem,"."));
            /*  verifica se a extensão está entre as extensões permitidas */
            if(in_array($ext,$permitidos)){
                /* converte o tamanho para KB */
                $tamanho = round($tamanho_imagem / 1024);
                if($tamanho < 1024){ //se imagem for até 1MB envia
                    $nome_atual = md5(uniqid(time())).$ext;
                    //nome que dará a imagem
                    $tmp = $_FILES['imagem']['tmp_name'];
                    //caminho temporário da imagem
                    /* se enviar a foto, insere o nome da foto no banco de dados */
                    if(move_uploaded_file($tmp,ASSETS.$nome_atual))
                        {
                    $this->produtos= $this->Produto->updateProdutos($_POST['descricao'],$_POST['status'],$nome_atual,$_POST['fornecedor'],$_POST['precoVenda'],$_POST['precoCompra'],$_POST['categoria'],$_POST['quantidade'],$_POST['id']);     
                    echo json_encode($this->produtos);
                }else{
                    echo "Falha ao enviar";
                    
                    }
            }else{
                echo "A imagem deve ser de no máximo 1MB";
                }
        }else{
            echo "Somente são aceitos arquivos do tipo Imagem";
            }
        }else{
            $this->produtos= $this->Produto->updateProdutos($_POST['descricao'],$_POST['status'],'',$_POST['fornecedor'],$_POST['precoVenda'],$_POST['precoCompra'],$_POST['categoria'],$_POST['quantidade'],$_POST['id']);     
            echo json_encode($this->produtos);
           }
    }else{
        echo "Selecione uma imagem";
        exit;
        }
    }


// CATEGORIAS
    public function Categoria()
    {
        $this->mostrarView('categorias','','','','');
    }
    public function Buscar_Categoria()
    {   
        
        if(@$_POST['dados']){           
            $this->categoria=$this->Categorias->getIdCategorias($_POST['dados']);
        }elseif(@$_POST['busca'])
        {
            $this->categoria=$this->Categorias->getNomeCategorias($_POST['busca']);
        }
        else{
            
            $this->categoria=$this->Categorias->getCategorias();
        
        }       
        echo json_encode($this->categoria);
    }

    public function inserir_Categoria()
    {   
          /* formatos de imagem permitidos */
                $permitidos = array(".jpg",".jpeg",".gif",".png", ".bmp");
                if(isset($_POST)){
                    $nome_imagem    = $_FILES['imagem']['name'];
                    $tamanho_imagem = $_FILES['imagem']['size'];
                    /* pega a extensão do arquivo */
                    $ext = strtolower(strrchr($nome_imagem,"."));
                    /*  verifica se a extensão está entre as extensões permitidas */
                    if(in_array($ext,$permitidos)){
                        /* converte o tamanho para KB */
                        $tamanho = round($tamanho_imagem / 1024);
                        if($tamanho < 1024){ //se imagem for até 1MB envia
                            $nome_atual = md5(uniqid(time())).$ext;
                            //nome que dará a imagem
                            $tmp = $_FILES['imagem']['tmp_name'];
                            //caminho temporário da imagem
                            /* se enviar a foto, insere o nome da foto no banco de dados */
                            if(move_uploaded_file($tmp,ASSETS.$nome_atual))
                                {

                                $this->categoria=$this->Categorias->insertCategorias($_POST['categoria'],$_POST['status'],$nome_atual);     
                                echo json_encode($this->categoria);
                            }else{
                                echo "Falha ao enviar";
                                
                                }
                        }else{
                            echo "A imagem deve ser de no máximo 1MB";
                            }
                    }else{
                        echo "Somente são aceitos arquivos do tipo Imagem";
                        }
                }else{
                    echo "Selecione uma imagem";
                    exit;
                    }
    }

    public function update_Categoria()
    {   
        /* formatos de imagem permitidos */
        $permitidos = array(".jpg",".jpeg",".gif",".png", ".bmp");
        if(isset($_POST)){
            if($_FILES['imagem']['name']!=''){
            $nome_imagem    = $_FILES['imagem']['name'];
            $tamanho_imagem = $_FILES['imagem']['size'];
            /* pega a extensão do arquivo */
            $ext = strtolower(strrchr($nome_imagem,"."));
            /*  verifica se a extensão está entre as extensões permitidas */
            if(in_array($ext,$permitidos)){
                /* converte o tamanho para KB */
                $tamanho = round($tamanho_imagem / 1024);
                if($tamanho < 1024){ //se imagem for até 1MB envia
                    $nome_atual = md5(uniqid(time())).$ext;
                    //nome que dará a imagem
                    $tmp = $_FILES['imagem']['tmp_name'];
                    //caminho temporário da imagem
                    /* se enviar a foto, insere o nome da foto no banco de dados */
                    if(move_uploaded_file($tmp,ASSETS.$nome_atual))
                        {
                    $this->categoria=$this->Categorias->updateCategorias($_POST['categoria'],$_POST['status'],$_POST['id'],$nome_atual);     
                    echo json_encode($this->categoria);
                }else{
                    echo "Falha ao enviar";
                    
                    }
            }else{
                echo "A imagem deve ser de no máximo 1MB";
                }
        }else{
            echo "Somente são aceitos arquivos do tipo Imagem";
            }
        }else{
            $this->categoria=$this->Categorias->updateCategorias($_POST['categoria'],$_POST['status'],$_POST['id'],'');     
            echo json_encode($this->categoria);
           }
    }else{
        echo "Selecione uma imagem";
        exit;
        }
    }


    public function Cliente()
    {
        $clientes= $this->Clientes->getClientes();
        $this->mostrarView('clientes',$clientes,'','','');
    }

    public function inserirCliente()
    {
        $this->apts=$this->Clientes->insertCliente(@$_POST['nome'],@$_POST['telefone'],@$_POST['endereco'],@$_POST['email']);     
        echo json_encode($this->apts);
    } 
    
    public function buscaIDcliente($dados)
    {   
        
            
            $this->apts=$this->Clientes->getIdCliente($dados);
        echo json_encode($this->apts);
    }
    public function inserir_Venda()
    {   
        $this->apts=$this->Vendas->insertVenda($_POST['vendas'],$_POST['cliente']);     
        echo json_encode($this->apts);
        // echo $_POST['vendas'];
    }

    public function updateCliente()
    {   
        $this->apts=$this->Clientes->updateCliente(@$_POST['nome'],@$_POST['telefone'],@$_POST['endereco'],@$_POST['email'],@$_POST['id']);     
        echo json_encode($this->apts);
    }



}