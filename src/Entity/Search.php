<?php

namespace App\Entity;

class Search
{

   private $exp;
   private $categorie;	
	private $city;
   private $type;
   private $qualification;
	private $titre;


public function getCity(): ?string
     {
		return $this->city;
	}

	public function setCity(string $city): self
     {
		$this->city = $city;

        return $this;
	}





	public function getTitre(): ?string
     {
		return $this->titre;
	}

	public function setTitre(string $titre): self
     {
		$this->titre = $titre;

        return $this;
	}

	public function getCategorie(): ?string
	{
	   return $this->categorie;
   }

   public function setCategorie(string $categorie): self
	{
	   $this->categorie = $categorie;

	   return $this;
   }

	public function getType(): ?string
     {
		return $this->type;
	}

	public function setType(string $type): self
     {
		$this->type = $type;

        return $this;
	}

	public function getExp(): ?string
     {
		return $this->exp;
	}

	public function setExp(string $exp): self
     {
		$this->exp = $exp;

        return $this;
	}

	public function getQualification(): ?string
	{
	   return $this->qualification;
   }

   public function setQualification(string $qualification): self
	{
	   $this->qualification = $qualification;

	   return $this;
   }

   

    


}