package com.oficinamecanica.apirest.service;

import org.springframework.data.jpa.repository.JpaRepository;

import com.oficinamecanica.apirest.entity.Pessoa;

public interface PessoaService extends JpaRepository<Pessoa, Long> {

}