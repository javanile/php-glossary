





test-root:
	@php -f glossary.php

test-small-app:
	@cd tests/fixtures/small-app && php -f ../../../glossary.php

