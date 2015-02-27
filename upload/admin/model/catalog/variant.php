<?php
class ModelCatalogVariant extends Model {
	public function addVariant($data) {
		$this->event->trigger('pre.admin.variant.add', $data);

		$this->db->query("INSERT INTO `" . DB_PREFIX . "related_variant` SET code = '" . $data['code'] . "'");

		$related_variant_id = $this->db->getLastId();

		foreach ($data['related_variant_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "related_variant_description SET related_variant_id = '" . (int)$related_variant_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value) . "'");
		}

		$this->event->trigger('post.admin.variant.add', $filter_group_id);

		return $related_variant_id;
	}

	public function editVariant($related_variant_id, $data) {
		$this->event->trigger('pre.admin.variant.edit', $data);

		$this->db->query("UPDATE `" . DB_PREFIX . "related_variant` SET code = '" . $data['code'] . "' WHERE related_variant_id = '" . (int)$related_variant_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "related_variant_description WHERE related_variant_id = '" . (int)$related_variant_id . "'");

		foreach ($data['related_variant_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "related_variant_description SET related_variant_id = '" . (int)$related_variant_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value) . "'");
		}

		$this->event->trigger('post.admin.variant.edit', $filter_group_id);
	}

	public function deleteVariant($related_variant_id) {
		$this->event->trigger('pre.admin.variant.delete', $related_variant_id);

		$this->db->query("DELETE FROM `" . DB_PREFIX . "related_variant_to_product` WHERE related_variant_id = '" . (int)$related_variant_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "related_variant_description` WHERE related_variant_id = '" . (int)$related_variant_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "related_variant` WHERE related_variant_id = '" . (int)$related_variant_id . "'");

		$this->event->trigger('post.admin.variant.delete', $related_variant_id);
	}

	public function getRelatedVariant($related_variant_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "related_variant` rv LEFT JOIN " . DB_PREFIX . "related_variant_description rvd ON (rv.related_variant_id = rvd.related_variant_id) WHERE rv.related_variant_id = '" . (int)$related_variant_id . "' AND rvd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getRelatedVariantDescriptions($related_variant_id) {
		$data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "related_variant_description WHERE related_variant_id = '" . (int)$related_variant_id . "'");

		foreach ($query->rows as $result) {
			$data[$result['language_id']] = $result['title'];
		}

		return $data;
	}

	public function getFilter($filter_id) {
		$query = $this->db->query("SELECT *, (SELECT name FROM " . DB_PREFIX . "filter_group_description fgd WHERE f.filter_group_id = fgd.filter_group_id AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS `group` FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE f.filter_id = '" . (int)$filter_id . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getVariants($data=array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "related_variant v LEFT JOIN " . DB_PREFIX . "related_variant_description vd ON (v.related_variant_id = vd.related_variant_id) WHERE vd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if (!empty($data['filter_code'])) {
			$sql .= " AND v.code LIKE '" . $this->db->escape($data['filter_code']) . "%'";
		}

		$sql .= " ORDER BY v.code ASC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getFilterDescriptions($filter_group_id) {
		$filter_data = array();

		$filter_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "filter WHERE filter_group_id = '" . (int)$filter_group_id . "'");

		foreach ($filter_query->rows as $filter) {
			$filter_description_data = array();

			$filter_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "filter_description WHERE filter_id = '" . (int)$filter['filter_id'] . "'");

			foreach ($filter_description_query->rows as $filter_description) {
				$filter_description_data[$filter_description['language_id']] = array('name' => $filter_description['name']);
			}

			$filter_data[] = array(
				'filter_id'          => $filter['filter_id'],
				'filter_description' => $filter_description_data,
				'sort_order'         => $filter['sort_order']
			);
		}

		return $filter_data;
	}

	public function getTotalVariants() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "related_variant`");

		return $query->row['total'];
	}
	
	public function getProductVariant($product_id){
		$res = $this->db->query("SELECT * FROM `" . DB_PREFIX . "related_variant_to_product` where product_id='" . (int)$product_id."' limit 1")->row;
		return $res?$res['related_variant_id']:null;
	}
}
