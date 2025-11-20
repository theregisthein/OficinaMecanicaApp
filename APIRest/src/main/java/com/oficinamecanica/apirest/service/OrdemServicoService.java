package com.oficinamecanica.apirest.service;

import java.util.List;
import java.util.Optional;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

import com.oficinamecanica.apirest.entity.OrdemServico;

public interface OrdemServicoService extends JpaRepository<OrdemServico, Long> {

    
    //Busca todas as OS, mas força o "join" para trazer os Itens (filhos)
    //na mesma consulta, evitando o erro de LazyInitialization.
    
    @Query("SELECT os FROM OrdemServico os LEFT JOIN FETCH os.itens")
    List<OrdemServico> findAllComItens();

    @Query("SELECT os FROM OrdemServico os LEFT JOIN FETCH os.itens WHERE os.id = :id")
    Optional<OrdemServico> findByIdComItens(@Param("id") Long id);

    

}

// "bug da preguiça" (Lazy Loading).

// OrdemservicoController (Laravel) chama o edit($id)
// O edit($id) chama o buscaPorId(Long id) do Proxy 8080
// O Proxy 8080 chama o GET /ordemServico/{id} da API 9090

// AQUI ESTA O BUG: O mEtodo read() (o @GetMapping("/ordemServico/{numero}")) na API 9090 está usando servOrdemServico.findById(numero)
// O findById padrão do JPA é "preguiçoso" (Lazy). Ele busca a "Mãe" (OrdemServico) mas não busca a lista de "Filhos" (itens)
// A API 9090 quebra com um erro 500 (LazyInitializationException) quando tenta converter em JSON
// O Laravel recebe um erro, e a variável $ordem na sua view de edição fica vazia ou com itens: null
// O seu JavaScript (edit.blade.php) tenta rodar let itensDaOS = @json($ordem['itens'] ?? []); e o itensDaOS fica como uma lista vazia
// quando clicaR em "Salvar", o JavaScript checa if (itensDaOS.length === 0)... e isso e verdadeiro
// Ele dispara o alert('Você precisa adicionar pelo menos um item à OS.'); e o return; (impedindo o salvamento)
// Se não ve nem o alert, significa que o $ordem está tão quebrado que o JavaScript quebrou antes, na linha let itensDaOS = @json($ordem['itens'] ?? []);