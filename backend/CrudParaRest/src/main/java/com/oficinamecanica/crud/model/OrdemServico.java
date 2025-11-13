package com.oficinamecanica.crud.model;
import java.time.LocalDateTime;

public class OrdemServico {
    private Integer id;
    private Integer cliente_id;
    private Integer veiculo_id;
    private LocalDateTime data_emissao;
    private String status;


    public OrdemServico() {
    }

    public OrdemServico(Integer id, Integer cliente_id, Integer veiculo_id, LocalDateTime data_emissao, String status) {
        this.id = id;
        this.cliente_id = cliente_id;
        this.veiculo_id = veiculo_id;
        this.data_emissao = data_emissao;
        this.status = status;
    }

    public Integer getId() {
        return this.id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public Integer getCliente_id() {
        return this.cliente_id;
    }

    public void setCliente_id(Integer cliente_id) {
        this.cliente_id = cliente_id;
    }

    public Integer getVeiculo_id() {
        return this.veiculo_id;
    }

    public void setVeiculo_id(Integer veiculo_id) {
        this.veiculo_id = veiculo_id;
    }

    public LocalDateTime getdata_emissao() {
        return this.data_emissao;
    }

    public void setdata_emissao(LocalDateTime data_emissao) {
        this.data_emissao = data_emissao;
    }

    public String getStatus() {
        return this.status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

}


