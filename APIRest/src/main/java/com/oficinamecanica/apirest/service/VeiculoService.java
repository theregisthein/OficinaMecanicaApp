package com.oficinamecanica.apirest.service;

import org.springframework.data.jpa.repository.JpaRepository;

import com.oficinamecanica.apirest.entity.Veiculo;

public interface VeiculoService extends JpaRepository<Veiculo, Long> {

}