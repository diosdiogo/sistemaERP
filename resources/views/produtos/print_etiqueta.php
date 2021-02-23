<?php
    

    date_default_timezone_set('America/Bahia');

    $data = date('Y-m-d H:i:s');

    $pont = array(".", "/" , "(", ")", "-","R","$",",");

    

    $produto = $_GET['pd'];
    
    $sqlProdutoId = "SELECT * FROM produto where idmatriz = :matriz and id = :id;";
    $stmtProdutoId = $pdo->prepare($sqlProdutoId);
    $stmtProdutoId->bindValue(':matriz', $_SESSION['empresa']['matriz']);
    $stmtProdutoId->bindValue(':id', $produto);
    $stmtProdutoId->execute();
    $rowProduto=  $stmtProdutoId->fetch(PDO::FETCH_ASSOC);

    //geraCodigoBarra($rowProduto['codigoreduzido']);
    
    function geraCodigoBarra($numero){
        $fino = 1;
        $largo = 3;
        $altura = 50;
        
        $barcodes[0] = '00110';
        $barcodes[1] = '10001';
        $barcodes[2] = '01001';
        $barcodes[3] = '11000';
        $barcodes[4] = '00101';
        $barcodes[5] = '10100';
        $barcodes[6] = '01100';
        $barcodes[7] = '00011';
        $barcodes[8] = '10010';
        $barcodes[9] = '01010';
        
        for($f1 = 9; $f1 >= 0; $f1--){
            for($f2 = 9; $f2 >= 0; $f2--){
                $f = ($f1*10)+$f2;
                $texto = '';
                for($i = 1; $i < 6; $i++){
                    $texto .= substr($barcodes[$f1], ($i-1), 1).substr($barcodes[$f2] ,($i-1), 1);
                }
                $barcodes[$f] = $texto;
            }
        }
        
        echo '<img src="imagens/p.gif" width="'.$fino.'" height="'.$altura.'" border="0" />';
        echo '<img src="imagens/b.gif" width="'.$fino.'" height="'.$altura.'" border="0" />';
        echo '<img src="imagens/p.gif" width="'.$fino.'" height="'.$altura.'" border="0" />';
        echo '<img src="imagens/b.gif" width="'.$fino.'" height="'.$altura.'" border="0" />';
        
        echo '<img ';
        
        $texto = $numero;
        
        if((strlen($texto) % 2) <> 0){
            $texto = '0'.$texto;
        }
        
        while(strlen($texto) > 0){
            $i = round(substr($texto, 0, 2));
            $texto = substr($texto, strlen($texto)-(strlen($texto)-2), (strlen($texto)-2));
        
            if(isset($barcodes[$i])){
                $f = $barcodes[$i];
            }
        
            for($i = 1; $i < 11; $i+=2){
                if(substr($f, ($i-1), 1) == '0'){
                    $f1 = $fino;
                }else{
                $f1 = $largo;
            }
        
            echo 'src="imagens/p.gif" width="'.$f1.'" height="'.$altura.'" border="0">';
            echo '<img ';
        
            if(substr($f, $i, 1) == '0'){
                $f2 = $fino;
            }else{
                $f2 = $largo;
            }
        
            echo 'src="imagens/b.gif" width="'.$f2.'" height="'.$altura.'" border="0">';
                echo '<img ';
            }
            }
            echo 'src="imagens/p.gif" width="'.$largo.'" height="'.$altura.'" border="0" />';
            echo '<img src="imagens/b.gif" width="'.$fino.'" height="'.$altura.'" border="0" />';
            echo '<img src="imagens/p.gif" width="1" height="'.$altura.'" border="0" />';

    }
    ?>
    
    <style>
        body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #FAFAFA;
        font: 12pt "Tahoma";
    }

    .principal{
        margin:0 auto;
        width:110mm;
    }
    .pagina {
        width: 35mm;
        height: 20mm;
       
        
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        float:left;
    }
    @page {
        size: 110mm;
        
    }
    
    
    </style>
    
    <body>
        <div class="principal">
            <div class="pagina">
                <div class="sub-pagina">Página 1/6</div>    
            </div>
            <div class="pagina">
                <div class="sub-pagina">Página 2/6</div>    
            </div>
            <div class="pagina">
                <div class="sub-pagina">Página 3/6</div>    
            </div>
            <div class="pagina">
                <div class="sub-pagina">Página 4/6</div>    
            </div>
            <div class="pagina">
                <div class="sub-pagina">Página 5/6</div>    
            </div>
            <div class="pagina">
                <div class="sub-pagina">Página 6/6  </div>    
            </div>
        </div>
    </body>