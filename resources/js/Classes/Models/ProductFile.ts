/**
 * Representa o arquivo do produto.
 */
export default interface ProductFile {
	name?: string,
	path?: string,
	file?: File,
	platform_ids: number[],
};
