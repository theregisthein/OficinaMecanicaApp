package com.oficinamecanica.apirest.entity;

import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;

@Entity
public class OrdemServico {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)

    private Long id;
    private Long cliente_id;
    private Long veiculo_id;
    private String data_emissao;
    private String status;

    public OrdemServico() {
    }


    public OrdemServico(Long id, Long cliente_id, Long veiculo_id, String data_emissao, String status) {
        this.id = id;
        this.cliente_id = cliente_id;
        this.veiculo_id = veiculo_id;
        this.data_emissao = data_emissao;
        this.status = status;
    }


    public Long getId() {
        return this.id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public Long getCliente_id() {
        return this.cliente_id;
    }

    public void setCliente_id(Long cliente_id) {
        this.cliente_id = cliente_id;
    }

    public Long getVeiculo_id() {
        return this.veiculo_id;
    }

    public void setVeiculo_id(Long veiculo_id) {
        this.veiculo_id = veiculo_id;
    }

    public String getData_emissao() {
        return this.data_emissao;
    }

    public void setData_emissao(String data_emissao) {
        this.data_emissao = data_emissao;
    }

    public String getStatus() {
        return this.status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

}

