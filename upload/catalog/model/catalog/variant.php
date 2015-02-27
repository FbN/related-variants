<?php
class ModelCatalogVariant extends Model {

	public function getRelatedVariant($related_variant_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "related_variant` rv LEFT JOIN " . DB_PREFIX . "related_variant_description rvd ON (rv.related_variant_id = rvd.related_variant_id) WHERE rv.related_variant_id = '" . (int)$related_variant_id . "' AND rvd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getRelatedVariantDescriptions($related_variant_id) {
		$data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "related_variant_description WHERE related_variant_id = '" . (int)$related_variant_id . "' AND language_id='" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	
	public function getProductVariant($product_id){
		$res = $this->db->query("SELECT * FROM `" . DB_PREFIX . "related_variant_to_product` where product_id='" . (int)$product_id."' limit 1")->row;
		return $res?$res['related_variant_id']:null;
	}
	
	public function getProductVariants($product_id){
		return $this->db->query("SELECT * FROM `" . DB_PREFIX . "related_variant_to_product` where product_id='" . (int)$product_id."'")->rows;
	}
	
	
}
