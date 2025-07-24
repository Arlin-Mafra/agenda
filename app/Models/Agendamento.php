<?php

class Agendamento extends BaseModel {
    private Cliente $cliente;
    private Profissional $profissional;
    private DateTime $dataHora;
    private string $status;
    private ?string $observacoes;
}
