1. Project Overview
    * This project is a Laravel-based API designed to ingest scan events from external sources. The system is built to handle unreliable and inconsistent data while ensuring data integrity, validation, and controlled storage.

2. Problem Addressed
    * Unreliable or incomplete input data
    * Duplicate scan events using scan_id
    * Validation of mixed data types (string, integer, date, nullable fields)
    * High-frequency API requests
    * Safe and consistent data storage
    * Null data handle

3. Rate Limiting
    * API requests are limited to 30 requests per minute per client using Laravel’s throttle middleware.
    * This prevents abuse and ensures system stability under high traffic.

4. API Key Validation
    * Each request is validated using an API key.
    * If the API key is missing, the request is rejected.
    * The key is compared with the value stored in the .env file.
    * This ensures only authorized requests access the API.

5. Validation Strategy 
   * A Laravel Form Request is used to validate all incoming data.
    Some fields are designed to be nullable at both the database and validation level. For these fields, if no value is provided in the request, they are explicitly stored as NULL in the database. 
   * Required fields are strictly enforced (e.g., scan_id).
   * Custom error messages are returned for clarity.
   * String fields are limited to 100 characters (config-based).
   * Integer fields are excluded from length validation.
   * This ensures clean and controlled input before processing.
   * The system uses htmlspecialchars() to safely encode special characters and prevent XSS attacks. It converts HTML symbols like < and > into safe text, ensuring no script execution during output rendering.
   * The GPS latitude and longitude will also be verified.

6. scan_id Idempotency (Duplicate Handling)
    * The scan_id acts as a unique identifier for each scan event.
    * Before insertion, the database is checked using scan_id.
    * scan_id is used as an idempotency key to prevent duplicate processing. Duplicate requests are rejected to maintain data consistency.
    * This prevents duplicate records and ensures uniqueness.

7. Transaction & Error Handling
    * All data insertion operations are wrapped inside a database transaction.
    * On success transaction is committed
    * On failure transaction is rolled back
    * This ensures no partial or corrupted data is stored
    * All exceptions are returned as error responses
    * Logged for debugging and traceability

8. Database Design & Indexing
    * The database is designed using Laravel migrations with:
    * Unique DB constraint on scan_id
    * Integer and nullable date fields
    * Indexed columns for optimized search and filtering
    * Indexes improve performance for query-heavy operations and enable faster data retrieval.

9. Key Design Decisions
    * Validation is implemented using both Laravel Form Request and config-based rules
    * Strict scan_id uniqueness to avoid duplicate ingestion
    * Transaction-based writes for data safety
    * Indexing applied for performance optimization
    * Validation-first approach before database interaction.

10. Summary
    This system is designed with a focus on:
    * Data integrity
    * Duplicate prevention
    * Input validation
    * Performance optimization
    * Safe transactional processing
    * Limited API usage to avoid high traffic
