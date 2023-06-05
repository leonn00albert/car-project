<?php

interface ActionInterface
{
    public function create(): bool;
    public function read(): array;
    public function update(): bool;
    public function delete(): bool;
}
