 let empresa = new Empresa();
 let titulo = window.titulo;
 loadJSON('/BBconfort/relatorios/test/empresa.json', function(response) {
     console.log(response);
     let json = JSON.parse(response);
     console.log(json);
     empresa.JSONtoEmpresa(json);
     console.log(empresa);
     let relatorio = new Relatorio(titulo,
         empresa);
     let itens = window.itens;
     relatorio.itensTable(itens);
     relatorio.createPage(); // relatorio.createPage(); 

 });