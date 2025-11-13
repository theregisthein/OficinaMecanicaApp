package com.oficinamecanica.crud.model;

public class Pessoa {
    private Integer id;
    private String nome;
    private String telefone;
    private String endereco;
    private String cpfcnpj;
    private String tipo;


    public Pessoa() {
    }

    public Pessoa(Integer id, String nome, String telefone, String endereco, String cpfcnpj, String tipo) {
        this.id = id;
        this.nome = nome;
        this.telefone = telefone;
        this.endereco = endereco;
        this.cpfcnpj = cpfcnpj;
        this.tipo = tipo;
    }
    

    public Integer getId() {
        return this.id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getNome() {
        return this.nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public String getTelefone() {
        return this.telefone;
    }

    public void setTelefone(String telefone) {
        this.telefone = telefone;
    }

    public String getEndereco() {
        return this.endereco;
    }

    public void setEndereco(String endereco) {
        this.endereco = endereco;
    }

    public String getCpfcnpj() {
        return this.cpfcnpj;
    }

    public void setCpfcnpj(String cpfcnpj) {
        this.cpfcnpj = cpfcnpj;
    }

    public String getTipo() {
        return this.tipo;
    }

    public void setTipo(String tipo) {
        this.tipo = tipo;
    }
    
}


