import type ProductFile from './ProductFile';


/**
 * Representa a versão do produto.
 */
export default interface Version {
	number?: number|string,
	fixes?: string,
	release_notes?: string,
	release_date?: number|string,
	files: ProductFile[],
};
