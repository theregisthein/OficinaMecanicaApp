package com.oficinamecanica.crud.client;

import java.net.URI;
import java.net.URISyntaxException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

import org.springframework.http.client.SimpleClientHttpRequestFactory;
import org.springframework.stereotype.Component;
import org.springframework.web.client.RestTemplate;

import com.oficinamecanica.crud.model.Item;

@Component
public class ItemClient {

  private static final String uri = "http://localhost:9090/item";
  private final RestTemplate restTemplate;

  public ItemClient() {
        SimpleClientHttpRequestFactory factory = new SimpleClientHttpRequestFactory();
        factory.setConnectTimeout(5000);
        factory.setReadTimeout(5000);
        this.restTemplate = new RestTemplate(factory);
  }

  public List<Item> listar() {
    List<Item> lista = new ArrayList<>();
    
    try {
         URI uri = new URI("http://localhost:9090/item");
         Item[] i = restTemplate.getForObject(uri, Item[].class);
         lista = Arrays.asList(i);
    } catch (URISyntaxException e) {
      e.printStackTrace();
    }
    return lista;
  }

  
  public void inserir(Item it) {
    try {
        URI uri = new URI("http://localhost:9090/item");
        restTemplate.postForObject(uri, it, Item.class);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public void atualizar(Item it) {
    try {
        restTemplate.put(uri, it);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public void excluir(Long id) {
    try {
        restTemplate.delete(uri + "/" + id);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }








}
