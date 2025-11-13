package com.oficinamecanica.apirest.controller;

import java.util.List;
import java.util.Optional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RestController;

import com.oficinamecanica.apirest.entity.OS_Item;
import com.oficinamecanica.apirest.service.OS_ItemService;

@RestController
public class OS_ItemController {
    
    @Autowired
    OS_ItemService servOS_Item;

    @PostMapping("/os_item")
    public OS_Item save(@RequestBody OS_Item osi) {
        servOS_Item.save(osi);
        return osi;
    }

    @GetMapping("/os_item")
    public List<OS_Item> list() {
        return servOS_Item.findAll();
    }

    @PutMapping("/os_item")
    public OS_Item update(@RequestBody OS_Item osi){
      servOS_Item.save(osi);
      return osi;
    }

    @DeleteMapping("/os_item/{id}")
    public Optional<OS_Item> delete(@PathVariable Long id){
      Optional<OS_Item> op = servOS_Item.findById(id);
      servOS_Item.delete(op.get());
      return op;
    }

    @GetMapping("/os_item/{numero}")
    public Optional<OS_Item> read(@PathVariable Long numero){
      Optional<OS_Item> osi = servOS_Item.findById(numero);
      return osi;
    }
}
