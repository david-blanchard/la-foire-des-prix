import type {Identifier} from './Traits/Identifier.ts';

export interface User extends Identifier {
    email: string;
    roles: string[];
    password?: string | null;
    isVerified: boolean;
    verificationToken?: string | null;
}
