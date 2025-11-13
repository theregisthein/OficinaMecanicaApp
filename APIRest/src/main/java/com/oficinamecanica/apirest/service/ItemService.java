package com.oficinamecanica.apirest.service;

import org.springframework.data.jpa.repository.JpaRepository;

import com.oficinamecanica.apirest.entity.Item;

public interface ItemService extends JpaRepository<Item, Long> {

}