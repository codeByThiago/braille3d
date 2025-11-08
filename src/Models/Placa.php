<?php 

namespace Models;

class Placa {
    public int $id;
    public int $user_id;
    public string $texto;
    public bool $uppercase;
    public bool $contracoes;
    public int $tam_forma;
    public string $altura_ponto;
    public string $diametro_ponto;
    public string $espessura;
    public string $margem;
    public bool $canto_referencia;
    public bool $suporte;

    public function __construct(array $data) {
        $this->id = $data['id'] ?? 0;
        $this->user_id = $data['user_id'] ?? 0;
        $this->texto = $data['texto'] ?? '';
        $this->uppercase = $data['uppercase'] ?? false;
        $this->contracoes = $data['contracoes'] ?? false;
        $this->tam_forma = $data['tam_forma'] ?? '';
        $this->altura_ponto = $data['altura_ponto'] ?? '';
        $this->diametro_ponto = $data['diametro_ponto'] ?? '';
        $this->espessura = $data['espessura'] ?? '';
        $this->margem = $data['margem'] ?? '';
        $this->canto_referencia = $data['canto_referencia'] ?? false;
        $this->suporte = $data['suporte'] ?? false;
    }
    
    // GETTERS E SETTERS

    public function getId(): int { return $this->id; }
    public function getUserId(): int { return $this->user_id; }
    public function getTexto(): string { return $this->texto; }
    public function isUppercase(): bool { return $this->uppercase; }
    public function hasContracoes(): bool { return $this->contracoes; }
    public function getTamForma(): int { return $this->tam_forma; }
    public function getAlturaPonto(): string { return $this->altura_ponto; }
    public function getDiametroPonto(): string { return $this->diametro_ponto; }
    public function getEspessura(): string { return $this->espessura; }
    public function getMargem(): string { return $this->margem; }
    public function hasCantoReferencia(): bool { return $this->canto_referencia; }
    public function hasSuporte(): bool { return $this->suporte; }

    // Setters
    public function setId(int $id): void { $this->id = $id; }
    public function setUserId(int $user_id): void { $this->user_id = $user_id; }
    public function setTexto(string $texto): void { $this->texto = $texto; }
    public function setUppercase(bool $uppercase): void { $this->uppercase = $uppercase; }
    public function setContracoes(bool $contracoes): void { $this->contracoes = $contracoes; }
    public function setTamForma(int $tam_forma): void { $this->tam_forma = $tam_forma; }
    public function setAlturaPonto(string $altura_ponto): void { $this->altura_ponto = $altura_ponto; }
    public function setDiametroPonto(string $diametro_ponto): void { $this->diametro_ponto = $diametro_ponto; }
    public function setEspessura(string $espessura): void { $this->espessura = $espessura; }
    public function setMargem(string $margem): void { $this->margem = $margem; }
    public function setCantoReferencia(bool $canto_referencia): void { $this->canto_referencia = $canto_referencia; }
    public function setSuporte(bool $suporte): void { $this->suporte = $suporte; }

    public function toArray(): array {
        return [
            'user_id' => $this->user_id,
            'texto' => $this->texto,
            'uppercase' => $this->uppercase,
            'contracoes' => $this->contracoes,
            'tam_forma' => $this->tam_forma,
            'altura_ponto' => $this->altura_ponto,
            'diametro_ponto' => $this->diametro_ponto,
            'espessura' => $this->espessura,
            'margem' => $this->margem,
            'canto_referencia' => $this->canto_referencia,
            'suporte' => $this->suporte
        ];
    }

}

?>