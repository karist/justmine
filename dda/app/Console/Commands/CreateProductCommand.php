<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateProductCommand extends Command
{
    public $name;
    public $description;

    public function __construct($name, $description )
    {
        $this->name = $name;
        $this->description = $description;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      // dd($this);
        $product = Product::create([
          'name' => $this->name,
          'description' => $this->description,
        ]);
        return $product;
    }
}
