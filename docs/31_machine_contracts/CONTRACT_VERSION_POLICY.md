# CONTRACT_VERSION_POLICY

## Purpose

This policy defines semantic-versioning and compatibility obligations for CRE8 machine contracts.

## Normative policy

- `contract_version` in success and error envelope `meta` MUST follow `MAJOR.MINOR.PATCH`.
- Additive, backward-compatible changes MUST increment `MINOR` and MUST NOT increment `MAJOR`.
- Breaking changes (field removal, required-field add, type narrowing, enum value removal) MUST increment `MAJOR`.
- Non-contract editorial-only changes SHOULD increment `PATCH` when the machine artifacts are regenerated.
- `feed_metadata_schema_version` MUST be versioned independently from `contract_version` and MUST only advance when feed metadata shape changes.
- Deprecation windows MUST be at least 90 days before removal for externally consumed contract fields.
- Sunset notices MUST be published in release notes and in `docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md` policy notes.
- Clients MUST treat unknown additive fields as ignorable unless explicitly prohibited by route-specific schema closure.

## Compatibility declaration references

- API guide reference: `docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md`
- Parity policy reference: `docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md`
