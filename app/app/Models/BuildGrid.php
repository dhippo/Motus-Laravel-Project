<?php

namespace App\Models;


class BuildGrid
{

    private int $nbRows;
    private int $nbColumns;

    public function __construct($nbRows, $nbColumns)
    {
        $this->nbRows = $nbRows;
        $this->nbColumns = $nbColumns;
    }

    public function buildGrid(): array
    {
        // Générer la grille en utilisant $this->rowCount et $this->colCount
        $grid = [];

        for ($i = 0; $i < $this->nbRows; $i++) {
            $row = [];
            for ($j = 0; $j < $this->nbColumns; $j++) {
                $row[] = ""; // Contenu de la case
            }
            $grid[] = $row;
        }

        return $grid;
    }

}
