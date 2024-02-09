import type Category from './Category';
import type Version from './Version';


/**
 * Representa o produto.
 */
export default interface Product {
	id?: number,
	title: string,
	slug: string,
	page: string,
	description: string,
	category_id?: number,
	price: number,
	active: boolean,
	cover_index: number,
	created_at: string,
	updated_at: string,

	cover?: string,
	images: string[],
	related_category: Category[],
	related_versions: Version[],
};
