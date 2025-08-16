import {Identifier} from './Traits/Identifier';

export interface User extends Identifier {
    email: string;
    roles: string[];
    password?: string | null;
    isVerified: boolean;
    verificationToken?: string | null;
}
