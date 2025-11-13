package com.oficinamecanica.apirest.service;

import org.springframework.data.jpa.repository.JpaRepository;

import com.oficinamecanica.apirest.entity.OrdemServico;

public interface OrdemServicoService extends JpaRepository<OrdemServico, Long> {

}