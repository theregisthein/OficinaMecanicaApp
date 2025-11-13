package com.oficinamecanica.apirest.service;

import org.springframework.data.jpa.repository.JpaRepository;

import com.oficinamecanica.apirest.entity.OS_Item;

public interface OS_ItemService extends JpaRepository<OS_Item, Long> {

}