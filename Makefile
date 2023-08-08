
test-root:
	@php bin/glossary

test-small-app:
	@cd tests/fixtures/small-app && php ../../../bin/glossary
