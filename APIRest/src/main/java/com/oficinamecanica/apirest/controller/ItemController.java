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

import com.oficinamecanica.apirest.entity.Item;
import com.oficinamecanica.apirest.service.ItemService;

@RestController
public class ItemController {
    
    @Autowired
    ItemService servItem;

    @PostMapping("/item")
    public Item save(@RequestBody Item ot) {
        servItem.save(ot);
        return ot;
    }

    @GetMapping("/item")
    public List<Item> list() {
        return servItem.findAll();
    }

    @PutMapping("/item")
    public Item update(@RequestBody Item it){
      servItem.save(it);
      return it;
    }

    @DeleteMapping("/item/{id}")
    public Optional<Item> delete(@PathVariable Long id){
      Optional<Item> i = servItem.findById(id);
      servItem.delete(i.get());
      return i;
    }

    @GetMapping("/item/{numero}")
    public Optional<Item> read(@PathVariable Long numero){
      Optional<Item> i = servItem.findById(numero);
      return i;
    }
}
