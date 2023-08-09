
test-root:
	@php bin/glossary

test-small-app:
	@cd tests/fixtures/small-app && php ../../../bin/glossary

test-default-config:
	@cd tests/fixtures/default-config && php ../../../bin/glossary

test-dump-domain-terms:
	@cd tests/fixtures/small-app && php ../../../bin/glossary --dump-domain-terms
