/**
 * Representa o arquivo do produto.
 */
export default interface ProductFile {
	id?: number,
	name?: string,
	path?: string,
	product_file?: File,
	platform_ids: number[],
};
