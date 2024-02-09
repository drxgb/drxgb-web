/**
 * Representa o arquivo do produto.
 */
export default interface ProductFile {
	id?: number,
	name?: string,
	size?: number,
	path?: string,
	product_file?: File,
	platform_ids?: number[],

	created_at?: string,
	updated_at?: string,
};
