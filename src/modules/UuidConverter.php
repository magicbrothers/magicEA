<?php
class UuidConverter {

	public function getUuid(string $name): string
	{
		if ($this->isUuid($name)) return $name;
		return $name;
	}

	public function getName(string $uuid): string
	{
		if (!$this->isUuid($uuid)) return $uuid;
		return $uuid;
	}

	private function isUuid(string $uuid): bool
	{
		return strpos($uuid, "-") !== false && strlen($uuid) == 36;
	}

}
