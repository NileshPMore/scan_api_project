1. Project Overview
   * This project is a Laravel-based API designed to receive and process scan events from external sources. It is built to handle unreliable or inconsistent data while ensuring validation, integrity, and secure storage.

2. Problem Statement
   The system addresses the following challenges:
   * Incomplete or unreliable input data
   * Duplicate scan events (based on scan_id)
   * Validation of mixed data types (string, numeric, date, nullable fields)
   * High-frequency API requests
   * Safe and consistent data storage
   * Proper handling of null values

3. Rate Limiting
   * API requests are limited to 30 requests per minute per client using Laravel’s throttle middleware.
   * This helps prevent abuse and maintains system stability under heavy traffic.

4. API Key Validation
   * Each request must include a valid API key
   * Requests without a key are rejected
   * The key is verified against the value stored in the .env file
   * This ensures that only authorized clients can access the API.

5. Validation Strategy
   * Laravel Form Request is used for validating incoming data
   * Required fields (e.g., scan_id) are strictly enforced
   * Nullable fields are allowed and stored as NULL when not provided
   * String fields are limited to 100 characters (configurable)
   * numeric fields are validated without length restrictions
   * Custom error messages improve clarity

   Additional protections:
   * htmlspecialchars() is used to encode special characters and prevent XSS attacks
   * GPS latitude and longitude values are validated for correctness
   * This approach ensures clean, safe, and consistent input before processing.

6. scan_id Idempotency (Duplicate Handling)
   * scan_id serves as a unique identifier for each scan event
   * It is used as an idempotency key to prevent duplicate processing
   * The system checks for existing records before insertion
   * Duplicate requests are rejected

7. Transactions & Error Handling
   * All database operations are wrapped in transactions
   * On success transaction is committed
   * On failure transaction is rolled back
   Benefits:
   * Prevents partial or corrupted data
   * Ensures data consistency
   Additionally:
   * Errors are returned as structured responses
   * Exceptions are logged for debugging and traceability

8. Database Design & Indexing
   The database is structured using Laravel migrations with:
   * A unique constraint on scan_id
   * Support for numeric and nullable date fields
   * Indexed columns for faster search and filtering
   * Indexes improve performance, especially for query-heavy operations.

9. Key Design Decisions
   * Validation-first approach before database interaction
   * Strict uniqueness of scan_id
   * Transaction-based writes for reliability
   * Config-driven validation rules
   * Indexing for performance optimization

10. Summary
   This system is designed with a focus on:
   * Data integrity
   * Duplicate prevention
   * Strong input validation
   * High performance
   * Safe transactional processing
   * Controlled API usage
NOTE : URL - http://127.0.0.1:8000/api/scanapidata
