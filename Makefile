commit:
	@git add .
	@git commit -m "fix"
	@git push

protoc:
	@echo "Обновление прото файлов из gisit-proto..."
	rm -rf temp-proto
	@git clone --depth 1 --filter=blob:none --sparse https://github.com/gisit-triggis/gisit-proto temp-proto
	cd temp-proto && git sparse-checkout set shared gen/php
	find temp-proto/shared -type f -name "*.proto" -exec cp {} proto/ \;
	cp -r temp-proto/gen/php/* generated/
	rm -rf temp-proto

PHONY: commit protoc
