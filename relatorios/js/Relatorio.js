class Relatorio {

    constructor(titulo, empresa) {
        this.page = null;
        this.titulo = titulo;
        this.empresa = empresa;
        let now = new Date();
        this.date = this.ajustaData(now.getDate()) + "/" + this.ajustaData(now.getMonth() + 1) + "/" + now.getFullYear();
        this.hora = this.ajustaData(now.getHours()) + ":" + this.ajustaData(now.getMinutes()) + ":" + this.ajustaData(now.getSeconds());
    }

    itensTable(itens) {
        this.itens = itens;
        this.atual = 0;
        this.sizeItens = itens.length;
        this.sizeCM = 0;
        this.contPages = 0;
    }

    createHeader() {
        let header = this.element('header');
        let logo = this.element('div', 'impar logo');
        this.setImageElement(logo, this.empresa.logo);

        let title = this.element('div', 'par title');
        this.setTextElement(title, this.titulo);

        let data = this.element('div', 'impar data');
        this.setTextElement(data, 'Data: ' + this.date + ' ' + this.hora);

        header.appendChild(logo);
        header.appendChild(title);
        header.appendChild(data);
        this.page.appendChild(header);
    }

    createPage() {
        this.contPages++;
        let containerRelatorio = this.element("div", "div_" + this.contPages);
        containerRelatorio.classList.add("container-relatorio");
        this.page = document.createElement("page");
        this.page.setAttribute("size", "A4");
        containerRelatorio.appendChild(this.page);
        let body = document.querySelector('body');
        body.appendChild(containerRelatorio);
        this.createHeader();
        this.createMain();
    }

    createMain() {
        let main = this.element('main');
        this.page.appendChild(main);
        this.createTable(main);
    }

    createFooter() {
        let footer = this.element('footer');
        this.setTextElement(footer, this.empresa.endereco);
        this.page.appendChild(footer);
    }

    createTable(main) {
        let table = this.element('table', 'page_' + this.contPages);
        let thead = this.element('thead');
        let tbody = this.element('tbody');

        table.appendChild(tbody);
        table.appendChild(thead);
        main.appendChild(table);
        this.populaTHead(this.itens[0], thead);
        this.populaTBody(tbody);
    }

    populaTHead(head, thead) {
        Object.keys(head)
            .forEach(function eachKey(key) {



                let th = document.createElement('th');
                let textItem = document.createTextNode(key);
                th.appendChild(textItem);
                thead.appendChild(th);


            });
    }

    populaTBody(body) {
        while (this.atual < this.sizeItens) {
            const element = this.itens[this.atual];
            let tr = this.element('tr');
            Object.keys(element)
                .forEach(function eachKey(key) {
                    let td = document.createElement('td');
                    // console.log(element[key]);
                    var result = element[key].indexOf('-') > -1;
                    if (result) {
                        var data = element[key];
                        data = data.split('-');
                        if (data.length > 2) {
                            let textItem = document.createTextNode(data[2] + '-' + data[1] + '-' + data[0]);
                            td.appendChild(textItem);
                            tr.appendChild(td);
                        } else {
                            let textItem = document.createTextNode(data[1] + '-' + data[0]);
                            td.appendChild(textItem);
                            tr.appendChild(td);
                        }
                    } else {
                        let textItem = document.createTextNode(element[key]);
                        td.appendChild(textItem);

                        tr.appendChild(td);
                    }
                });

            tr.setAttribute('id', 'tr_' + this.contPages + '_' + this.atual);
            body.appendChild(tr);
            let tableAtual = document.querySelector('.page_' + this.contPages);
            // tamanhoBody += tr_tam.offsetHeight;
            if (tableAtual.offsetHeight > 898) {
                body.removeChild(tr);
                this.createFooter();
                this.createPage();
            } else {
                this.atual++;
            }
            // console.log(tableAtual.offsetHeight);
        }
    }

    setTextElement(element, text) {
        let span = this.element('span');
        let textItem = document.createTextNode(text);
        span.appendChild(textItem);
        element.appendChild(span);
    }

    setImageElement(element, src) {
        let img = this.element('img');
        img.setAttribute('src', src);
        element.appendChild(img);
    }

    element(tag, classe = '') {
        let item = document.createElement(tag);
        item.setAttribute('class', classe);
        return item;
    }

    elementHTML(tag, classe = '') {
        return `<${tag} class='${classe}'></${tag}>`;
    }

    ajustaData(num) {
        num = num.toString();
        console.log(num);
        return (num.length == 1) ? '0' + num : num;
    }

}

// export default Relatorio;