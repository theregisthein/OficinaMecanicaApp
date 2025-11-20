package com.oficinamecanica.crud.model;

public class Pessoa {
    private Long id;
    private String nome;
    private String telefone;
    private String endereco;
    private String cpfcnpj;
    private String tipo; //fisoca ou juridica
    private String perfil; //funcionario ou cliente
    private String email; 
    private String senha;


    public Pessoa() {
    }

    public Pessoa(Long id, String nome, String telefone, String endereco, String cpfcnpj, String tipo, String perfil, String email, String senha) {
        this.id = id;
        this.nome = nome;
        this.telefone = telefone;
        this.endereco = endereco;
        this.cpfcnpj = cpfcnpj;
        this.tipo = tipo;
        this.perfil = perfil;
        this.email = email;
        this.senha = senha;
    }
    

    public Long getId() {
        return this.id;
    }

    public void setId(Long id) {
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

    public String getPerfil() { 
        return perfil; 
    }
    public void setPerfil(String perfil) { 
        this.perfil = perfil; 
    }

    public String getEmail() { 
        return email; 
    }
    public void setEmail(String email) { 
        this.email = email; 
    }

    public String getSenha() { 
        return senha; 
    }
    public void setSenha(String senha) { 
        this.senha = senha; 
    }
    
}


