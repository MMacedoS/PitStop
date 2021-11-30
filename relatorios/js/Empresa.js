class Empresa {
    constructor() {}

    JSONtoEmpresa(json) {
        this.nome = json.nome;
        this.logo = json.logo;
        this.endereco = json.endereco;
    }

    set nomeEmpresa(nome) {
        this.nome = nome;
    }
}

// export default Empresa;