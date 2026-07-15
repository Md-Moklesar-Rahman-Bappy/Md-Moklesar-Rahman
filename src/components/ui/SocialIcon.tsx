import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { fab } from "@fortawesome/free-brands-svg-icons";
import { faLink } from "@fortawesome/free-solid-svg-icons";
import type { IconDefinition } from "@fortawesome/fontawesome-svg-core";

const SOCIAL_MAP: Record<string, IconDefinition> = {
  github: fab.faGithub,
  linkedin: fab.faLinkedin,
  twitter: fab.faXTwitter,
  facebook: fab.faFacebook,
  instagram: fab.faInstagram,
  youtube: fab.faYoutube,
  dribbble: fab.faDribbble,
  behance: fab.faBehance,
  codepen: fab.faCodepen,
  stackoverflow: fab.faStackOverflow,
  medium: fab.faMedium,
  dev: fab.faDev,
  hashnode: fab.faHashnode,
  link: faLink,
};

interface SocialIconProps {
  icon: string;
  className?: string;
}

export function SocialIcon({ icon, className = "" }: SocialIconProps) {
  const def = SOCIAL_MAP[icon.toLowerCase()] || faLink;
  return <FontAwesomeIcon icon={def} className={className} />;
}
