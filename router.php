<?php
    if($route[2] == 'home'){
        
        include_once 'resources/views/home.php';
    }

    //empresa router --------------------------------------------------------------------------

    else if($route[2] == 'empresa'){
        
        include_once 'resources/views/empresa/empresa.php';
    }
    else if(substr($route[2], 0, strpos($route[2], '?')) == 'empresa'){
        include_once 'resources/views/empresa/empresa.php';
    }
    else if($route[2] == 'empresa_registro'){
        
        include_once 'resources/views/empresa/empresa_registro.php';
    }
    else if($route[2] == 'empresa_salvar_editar'){
        
        include_once 'resources/views/empresa/empresa_salvar_editar.php';
    }
    

    //clientes router --------------------------------------------------------------------------
    else if($route[2] == 'clientes'){
        
        include_once 'resources/views/clientes/clientes.php';
    }
    else if(substr($route[2], 0, strpos($route[2], '?')) == 'clientes'){
        
        include_once 'resources/views/clientes/clientes.php';
    }
    else if($route[2] == 'cliente-registro'){
        
        include_once 'resources/views/clientes/cliente_registro.php';
    }
    else if($route[2] == 'cliente-salvar-editar'){
        
        include_once 'resources/views/clientes/cliente-salvar-editar.php';
    }

    //fornecedor router --------------------------------------------------------------------------

    else if($route[2] == 'fornecedores'){
        
        include_once 'resources/views/fornecedores/fornecedores.php';
    }
    else if(substr($route[2], 0, strpos($route[2], '?')) == 'fornecedores'){
        
        include_once 'resources/views/fornecedores/fornecedores.php';
    }
    else if($route[2] == 'fornecedor_registro'){
        include_once 'resources/views/fornecedores/fornecedor_registro.php';
    }
    else if($route[2] == 'fornecedor_salvar_editar'){
        include_once 'resources/views/fornecedores/fornecedor_salvar_editar.php';
    }

    //Funcionarios --------------------------------------------------------------------------

    else if($route[2] == 'funcionarios'){
        
        include_once 'resources/views/funcionarios/funcionarios.php';
    }
    else if(substr($route[2], 0, strpos($route[2], '?')) == 'funcionarios'){
       
        include_once 'resources/views/funcionarios/funcionarios.php';
    }
    else if($route[2] == 'funcionario_registro'){

        include_once 'resources/views/funcionarios/funcionario_registro.php';
    }

    else if($route[2] == 'funcionario_salvar_editar'){
        
        include_once 'resources/views/funcionarios/funcionario_salvar_editar.php';
    }

    //Transportadora --------------------------------------------------------------------------
    else if($route[2] == 'transportadoras'){
        
        include_once 'resources/views/transportadoras/transportadoras.php';
    }
    else if(substr($route[2], 0, strpos($route[2], '?')) == 'transportadoras'){
       
        include_once 'resources/views/transportadoras/transportadoras.php';
    }
    else if($route[2] == 'transportadora_registro'){

        include_once 'resources/views/transportadoras/transportadora_registro.php';
    }
    else if($route[2] == 'transportadora_salvar_editar'){

        include_once 'resources/views/transportadoras/transportadora_salvar_editar.php';
    }

    //usuários --------------------------------------------------------------------------
    else if($route[2] == 'usuarios'){
        
        include_once 'resources/views/usuarios/usuarios.php';
    }
    else if($route[2] == 'pessoa'){
        
        include_once 'resources/views/pessoas/pessoa.php';
    }

    //Produtos ---------------------------------------------------------------------------
    else if($route[2] == 'produtos'){
        
        include_once 'resources/views/produtos/produtos.php';
    }
    else if(substr($route[2], 0, strpos($route[2], '?')) == 'produtos'){
        
        include_once 'resources/views/produtos/produtos.php';
    }
    else if($route[2] == 'produto_registro'){
        include_once 'resources/views/produtos/produto_registro.php';
    }
    else if($route[2] == 'produtos_salvar_editar'){
        include_once 'resources/views/produtos/produtos_salvar_editar.php';
    }

    else if($route[2] == 'categoria'){
        include_once 'resources/views/categoria/categoria.php';
    }
    else if($route[2] == 'subcategoria'){
        include_once 'resources/views/subcategora/subcategoria.php';
    }

    //etiqueta
    else if(substr($route[2], 0, strpos($route[2], '?')) == 'print_etiqueta'){
        include_once 'resources/views/produtos/print_etiqueta.php';
    }

    //Lançar estoque

    else if($route[2] == 'lanc_estoque'){
        include_once 'resources/views/estoque/lanc_estoque.php';
    }
    else if(substr($route[2], 0, strpos($route[2], '?')) == 'lanc_estoque'){
        include_once 'resources/views/estoque/lanc_estoque.php';
    }
    
    else if($route[2] == 'estoque_lanc'){
        include_once 'resources/views/estoque/estoque_lanc.php';
    }
    else if($route[2] == 'estoque_salvar_editar'){
        include_once 'resources/views/estoque/estoque_salvar_editar.php';
    }

    //Faturamento
    else if($route[2] == 'vendas'){
        
        include_once 'resources/views/vendas/vendas.php';
    }
    else if($route[2] == 'os-abertas'){
        
        include_once 'resources/views/os-aberta/os-aberta.php';
    }

    else if($route[2] == 'PDV'){
        
        include_once 'resources/views/PDV/PDV.php';
    }

    else if($route[2] == 'condicionais'){
        
        include_once 'resources/views/condicionais/condicionais.php';
    }

    else if($route[2] == 'selecioneEmpresa'){
        include_once 'resources/views/selecioneEmpresa.php';
    }
    else if($route[2] == 'empresaSelecionada'){
        include_once 'resources/views/empresaSelecionada.php';
    }   
?>