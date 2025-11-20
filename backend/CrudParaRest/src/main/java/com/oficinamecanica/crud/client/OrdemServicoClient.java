package com.oficinamecanica.crud.client;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

import org.springframework.http.client.SimpleClientHttpRequestFactory;
import org.springframework.stereotype.Component;
import org.springframework.web.client.RestTemplate;

import com.oficinamecanica.crud.model.OrdemServico;

@Component
public class OrdemServicoClient {

    private static final String uri = "http://localhost:9090/ordemServico";
    private final RestTemplate restTemplate;

    public OrdemServicoClient() {
        SimpleClientHttpRequestFactory factory = new SimpleClientHttpRequestFactory();
        factory.setConnectTimeout(5000);
        factory.setReadTimeout(5000);
        this.restTemplate = new RestTemplate(factory);
    }

    public List<OrdemServico> listar() {
        List<OrdemServico> lista = new ArrayList<>();
    
        try {
            OrdemServico[] os = restTemplate.getForObject(uri, OrdemServico[].class);
            lista = Arrays.asList(os);
        } catch (Exception e) {
            e.printStackTrace();
            // joga o erro para o Laravel ver
            throw new RuntimeException("Erro ao LISTAR OS: " + e.getMessage());
        }
        return lista;
    }

 
    public void inserir(OrdemServico os) {
        try {
            restTemplate.postForObject(uri, os, OrdemServico.class);
        } catch (Exception e) {
            e.printStackTrace();
            throw new RuntimeException("Erro ao INSERIR OS: " + e.getMessage());
        }
    }

    public void atualizar(Long id, OrdemServico os) {
        try {
            String urlDestino = uri; 
            os.setId(id); 
            
            restTemplate.put(urlDestino, os);
        } catch (Exception e) {
            e.printStackTrace();
            throw new RuntimeException("Erro ao ATUALIZAR OS: " + e.getMessage());
        }
    }

    public void excluir(Long id) {
        try {
            restTemplate.delete(uri + "/" + id);
        } catch (Exception e) {
            e.printStackTrace();
            throw new RuntimeException("Erro ao EXCLUIR OS: " + e.getMessage());
        }
    }

    public OrdemServico buscaPorId(Long id) {
        try {
            String urlDestino = uri + "/" + id;
            return restTemplate.getForObject(urlDestino, OrdemServico.class);
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }
}